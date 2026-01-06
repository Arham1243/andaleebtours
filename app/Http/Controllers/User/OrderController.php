<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Country;
use App\Models\Config;
use Carbon\Carbon;
use App\Models\UserCoupon;
use App\Services\PrioTicketService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $adminEmail;
    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->adminEmail = $config['ADMINEMAIL'] ?? 'info@andaleebtours.com';
    }

    public function index()
    {
        $user = auth()->user();

        // Get orders for this user (both authenticated and guest orders by email)
        $orders = Order::with('orderItems.tour')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('passenger_email', $user->email);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.orders.list', compact('orders'))->with('title', 'My Orders');
    }

    public function show($id)
    {
        $user = auth()->user();

        // Get order only if it belongs to this user (by user_id or email)
        $order = Order::with('orderItems.tour')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('passenger_email', $user->email);
            })
            ->findOrFail($id);

        // Get country name from country ID
        $country = null;
        if ($order->passenger_country) {
            $country = Country::find($order->passenger_country);
        }

        // Get config for tax percentages
        $config = \Illuminate\Support\Facades\View::shared('config', []);

        return view('user.orders.show', compact('order', 'country', 'config'))->with('title', 'Order ' . $order->order_number);
    }

    public function destroy($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        $order->delete();
        return redirect()->route('user.orders.index')->with('notify_success', 'Order deleted successfully!');
    }

    public function payAgain($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        return view('user.orders.pay-again', compact('order'))->with('title', 'Pay Again');
    }

    public function proceedPayAgain(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:payby,tabby',
        ]);

        $order = Order::with('orderItems')->where('id', $id)->firstOrFail();

        // Build cart-like data structure from order items for validation
        $orderData = $this->buildOrderDataForValidation($order);

        // Step 1: Validate availability from PrioTicket API
        $availabilityCheck = $this->validateOrderAvailability($orderData);
        if (!$availabilityCheck['valid']) {
            DB::transaction(function () use ($order) {
                // Delete order items first
                $order->orderItems()->delete();

                // Then delete the order
                $order->delete();
            });
            return redirect()
                ->route('user.orders.show', $order->id)
                ->with('notify_error', 'This booking is no longer available and has been removed. Please place a new order.');
        }

        // Step 2: Validate coupon usage if order had coupons
        if (!empty($order->applied_coupons)) {
            $couponValidation = $this->validateCouponUsage($order->applied_coupons, $order->passenger_email);
            if (!$couponValidation['valid']) {
                return redirect()
                    ->route('user.orders.show', $order->id)
                    ->with('notify_error', $couponValidation['message']);
            }
        }

        DB::beginTransaction();

        try {
            // Step 3: Recalculate totals if payment method changed (for Tabby fee)
            $finalTotal = $this->recalculateOrderTotal($order, $request->payment_method);

            // Step 4: Update order with new payment method and totals
            $order->update([
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'tabby_fee' => $finalTotal['tabby_fee'],
                'total' => $finalTotal['final_total'],
            ]);

            // Step 5: Generate new booking references for fresh reservation
            $this->generateNewBookingReferences($order);

            // Step 6: Process PrioTicket reservation
            $prioTicketItems = $this->buildPrioTicketItems($order);
            $this->processPrioTicketReservation($order, $prioTicketItems);

            DB::commit();

            // Step 6: Redirect to payment gateway
            $paymentService = new PaymentService();
            $redirectUrl = $paymentService->getRedirectUrl($order, $request->payment_method);

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Pay again failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('user.orders.show', $order->id)
                ->with('notify_error', 'Failed to process payment. Please try again.');
        }
    }

    private function buildOrderDataForValidation(Order $order): array
    {
        $tours = [];

        foreach ($order->orderItems as $item) {
            $tours[] = [
                'product_id_prio' => $item->product_id_prio,
                'availability_id' => $item->availability_id,
                'date' => $item->booking_date,
                'total_pax' => $item->quantity,
                'name' => $item->tour_name,
                'has_capacity' => $item->tour->has_capacity ?? true,
            ];
        }

        return ['tours' => $tours];
    }

    private function validateOrderAvailability(array $orderData): array
    {
        $prioService = new PrioTicketService();
        $accessToken = $prioService->getAccessToken();

        if (!$accessToken) {
            return [
                'valid' => false,
                'message' => 'Unable to verify availability at the moment. Please try again later.',
            ];
        }

        foreach ($orderData['tours'] as $item) {
            // Skip if no PrioTicket integration
            if (empty($item['product_id_prio']) || empty($item['availability_id'])) {
                continue;
            }

            $date = Carbon::parse($item['date'])->toIso8601String();
            $result = $prioService->checkAvailability(
                $item['product_id_prio'],
                $item['availability_id'],
                $date,
                $item['total_pax'],
                $accessToken,
                $item['has_capacity'] ?? true
            );

            if (!$result['success']) {
                return [
                    'valid' => false,
                    'message' => "{$item['name']} is no longer available for the selected date and time. Please contact support.",
                ];
            }
        }

        return ['valid' => true];
    }

    private function validateCouponUsage(array $appliedCoupons, string $email): array
    {
        foreach ($appliedCoupons as $coupon) {
            if (!$this->canUseCoupon($email, $coupon['id'])) {
                return [
                    'valid' => false,
                    'message' => "The coupon '{$coupon['code']}' has already been used with this email address. Please contact support if you believe this is an error."
                ];
            }
        }

        return ['valid' => true];
    }

    private function canUseCoupon(string $email, int $couponId): bool
    {
        return !UserCoupon::where('email', $email)
            ->where('coupon_id', $couponId)
            ->exists();
    }

    private function recalculateOrderTotal(Order $order, string $paymentMethod): array
    {
        $tabbyFee = 0;
        $baseTotal = $order->subtotal - $order->discount + $order->vat + $order->service_tax;

        if ($paymentMethod === 'tabby') {
            $tabbyFee = $baseTotal * 0.08;
        }

        $finalTotal = $baseTotal + $tabbyFee;

        return [
            'tabby_fee' => $tabbyFee,
            'final_total' => $finalTotal,
        ];
    }

    private function generateNewBookingReferences(Order $order): void
    {
        // Generate a unique PrioTicket booking reference for this payment attempt
        // This keeps the original order_number intact but creates a new reference for PrioTicket
        $prioReference = 'PRIO-' . strtoupper(uniqid()) . '-' . time();
        
        // Update the order with new PrioTicket booking reference
        $order->update([
            'prio_booking_reference' => $prioReference,
        ]);

        // Reload the order to get the updated prio_booking_reference
        $order->refresh();
    }

    private function buildPrioTicketItems(Order $order): array
    {
        $prioTicketItems = [];

        foreach ($order->orderItems as $item) {
            // Skip if no PrioTicket integration
            if (empty($item->product_id_prio) || empty($item->availability_id)) {
                continue;
            }

            $productTypeDetails = [];
            $paxDetails = is_array($item->pax_details) ? $item->pax_details : [];

            foreach ($paxDetails as $pax) {
                $productTypeDetails[] = [
                    'product_type_id' => $pax['product_type_id'],
                    'product_type_count' => $pax['qty'],
                ];
            }

            $prioTicketItems[] = [
                'order_item_id' => $item->id,
                'tour_id' => $item->tour_id,
                'product_id_prio' => $item->product_id_prio,
                'availability_id' => $item->availability_id,
                'product_type_details' => $productTypeDetails,
            ];
        }

        return $prioTicketItems;
    }

    private function processPrioTicketReservation(Order $order, array $prioTicketItems): void
    {
        if (empty($prioTicketItems)) {
            return;
        }

        $prioService = new PrioTicketService();
        $accessToken = $prioService->getAccessToken();

        if (!$accessToken) {
            Log::error('PrioTicket: Access token missing', [
                'order_id' => $order->id
            ]);
            return;
        }

        // VALIDATE PRODUCTS
        foreach ($prioTicketItems as $item) {
            $productResponse = $prioService->fetchProduct(
                $item['product_id_prio'],
                $accessToken
            );
            $product = $productResponse['data']['product'] ?? null;

            if (!$product) {
                Log::error('PrioTicket: Product missing in response', [
                    'order_id' => $order->id,
                    'product_id' => $item['product_id_prio'],
                ]);
                return;
            }

            if (($product['product_status'] ?? null) !== 'ACTIVE') {
                Log::error('PrioTicket: Product not active', [
                    'order_id' => $order->id,
                    'product_id' => $item['product_id_prio'],
                    'status' => $product['product_status'] ?? null,
                ]);
                return;
            }
        }

        // BUILD RESERVATION PAYLOAD
        $reservationPayload = $prioService->buildReservationPayload(
            $order,
            $prioTicketItems,
            [
                'first_name' => $order->passenger_first_name,
                'last_name' => $order->passenger_last_name,
                'email' => $order->passenger_email,
                'phone' => $order->passenger_phone,
                'address' => $order->passenger_address,
                'country_code' => $order->passenger_country,
                'city' => null,
                'region' => null,
                'postal_code' => null,
            ]
        );

        // CREATE RESERVATION
        $reservationResponse = $prioService->createReservation(
            $reservationPayload,
            $accessToken
        );

        if ($reservationResponse['success']) {
            $this->updateOrderWithReservation(
                $order,
                $reservationResponse,
                $prioTicketItems
            );
            return;
        }

        Log::error('PrioTicket reservation failed', [
            'order_id' => $order->id,
            'error' => $reservationResponse['error']
        ]);
    }

    private function updateOrderWithReservation(Order $order, array $reservationResponse, array $prioTicketItems): void
    {
        $order->update([
            'reservation_reference' => $reservationResponse['data']['data']['reservation']['reservation_reference'] ?? null,
            'reservation_data' => json_encode($reservationResponse['data']),
        ]);

        $allConfirmed = true;

        if (isset($reservationResponse['data']['data']['reservation']['reservation_details'])) {
            foreach ($reservationResponse['data']['data']['reservation']['reservation_details'] as $index => $detail) {
                $status = isset($prioTicketItems[$index]) ? 'confirmed' : 'failed';
                if ($status === 'failed') $allConfirmed = false;
                if (isset($prioTicketItems[$index])) {
                    \App\Models\OrderItem::where('id', $prioTicketItems[$index]['order_item_id'])
                        ->update([
                            'booking_reference' => $detail['booking_reservation_reference'] ?? null,
                            'reservation_response' => json_encode($detail),
                            'status' => 'confirmed',
                        ]);
                }
            }
        }
        $order->update([
            'status' => $allConfirmed ? 'confirmed' : 'partial',
        ]);
    }

    public function cancel($id)
    {
        try {
            $user = auth()->user();

            $order = Order::with('orderItems.tour')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('passenger_email', $user->email);
                })
                ->findOrFail($id);

            if ($order->status === 'cancelled') {
                return redirect()->back()->with('notify_error', 'This order is already cancelled.');
            }

            if ($order->payment_status !== 'paid') {
                return redirect()->back()->with('notify_error', 'Only paid orders can be cancelled.');
            }

            $prioService = new PrioTicketService();
            $result = $prioService->cancelOrder($order);

            if (!$result['success']) {
                return redirect()->back()->with('notify_error', 'Failed to cancel order: ' . ($result['error'] ?? 'Unknown error'));
            }

            $order->update([
                'status' => 'cancelled',
                'prio_cancel_response' => json_encode($result['cancel_responses'] ?? []),
                'cancelled_at' => now(),
                'cancelled_by' => 'user'
            ]);

            $order->orderItems()->update([
                'status' => 'cancelled'
            ]);

            $this->sendCancellationEmails($order);

            Log::info('Order cancelled by user', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $user->id
            ]);

            return redirect()->route('user.orders.show', $id)->with('notify_success', 'Order cancelled successfully.');

        } catch (\Exception $e) {
            Log::error('Order cancellation failed', [
                'order_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('notify_error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    protected function sendCancellationEmails(Order $order)
    {
        try {
            $order->load('orderItems');

            // Send email to user
            Mail::send('emails.booking-cancelled-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Booking Cancelled - ' . $order->order_number);
            });

            // Send email to admin
            Mail::send('emails.booking-cancelled-admin', ['order' => $order], function ($message) use ($order) {
                $message->to($this->adminEmail)
                    ->subject('Order Cancelled by User - ' . $order->order_number);
            });

            Log::info('Cancellation emails sent', [
                'order_id' => $order->id,
                'customer_email' => $order->passenger_email,
                'admin_email' => $this->adminEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send cancellation emails', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}

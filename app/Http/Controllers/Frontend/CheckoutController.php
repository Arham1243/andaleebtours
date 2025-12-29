<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tour;
use App\Models\Country;
use App\Models\UserCoupon;
use App\Services\PrioTicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name', 'asc')->get();

        $cartData = session()->get('cart', [
            'tours' => [],
            'applied_coupons' => [],
            'total' => [
                'subtotal' => 0,
                'discount' => 0,
                'vat' => 0,
                'service_tax' => 0,
                'tax' => 0,
                'grand_total' => 0,
            ]
        ]);

        if (empty($cartData['tours'])) {
            return redirect()->route('frontend.cart.index')
                ->with('notify_error', 'Your cart is empty. Please add some tours before checkout.');
        }

        $tours = Tour::whereIn('id', array_keys($cartData['tours']))->get();

        return view('frontend.checkout.index', compact('cartData', 'tours', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'passenger.title' => 'required|string',
            'passenger.first_name' => 'required|string|max:255',
            'passenger.last_name' => 'required|string|max:255',
            'passenger.email' => 'required|email|max:255',
            'passenger.phone' => 'required|string|max:20',
            'passenger.country' => 'required|string|max:255',
            'passenger.address' => 'required|string|max:500',
            'payment_method' => 'required|in:card,tabby',
        ]);

        $cartData = $this->getCartData();

        if (empty($cartData['tours'])) {
            return redirect()->route('frontend.cart.index')
                ->with('notify_error', 'Your cart is empty.');
        }

        DB::beginTransaction();


        // Validate coupon usage before creating order
        if (!empty($cartData['applied_coupons'])) {
            $couponValidation = $this->validateCouponUsage($cartData['applied_coupons'], 
            $request->passenger['email']);
            if (!$couponValidation['valid']) {
                return redirect()
                    ->route('frontend.checkout.index')
                    ->with('notify_error', $couponValidation['message']);
            }
        }

        try {
            $finalTotal = $this->calculateFinalTotal($cartData, $request->payment_method);
            $order = $this->createOrder($request, $cartData, $finalTotal);
            $prioTicketItems = $this->createOrderItems($order, $cartData);

            $this->processPrioTicketReservation($order, $prioTicketItems, $request->passenger);
            $this->trackCouponUsage($order, $request->passenger['email']);

            DB::commit();

            session()->forget('cart');
            session()->put('order_number', $order->order_number);

            return redirect()
                ->route('frontend.payment.success')
                ->with('notify_success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('frontend.payment.failed')
                ->with('notify_error', 'Failed to create order. Please try again.');
        }
    }

    private function getCartData(): array
    {
        return session()->get('cart', [
            'tours' => [],
            'applied_coupons' => [],
            'total' => [
                'subtotal' => 0,
                'discount' => 0,
                'vat' => 0,
                'service_tax' => 0,
                'tax' => 0,
                'grand_total' => 0,
            ]
        ]);
    }

    private function calculateFinalTotal(array $cartData, string $paymentMethod): array
    {
        $tabbyFee = 0;
        $finalTotal = $cartData['total']['grand_total'];

        if ($paymentMethod === 'tabby') {
            $tabbyFee = $finalTotal * 0.08;
            $finalTotal += $tabbyFee;
        }

        return [
            'tabby_fee' => $tabbyFee,
            'final_total' => $finalTotal,
        ];
    }

    private function createOrder(Request $request, array $cartData, array $totalData): Order
    {
        return Order::create([
            'user_id' => auth()->id(), // null for guests
            'order_number' => Order::generateOrderNumber(),
            'passenger_title' => $request->passenger['title'],
            'passenger_first_name' => $request->passenger['first_name'],
            'passenger_last_name' => $request->passenger['last_name'],
            'passenger_email' => $request->passenger['email'],
            'passenger_phone' => $request->passenger['phone'],
            'passenger_country' => $request->passenger['country'],
            'passenger_address' => $request->passenger['address'],
            'passenger_special_request' => $request->passenger['special_request'] ?? null,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'subtotal' => $cartData['total']['subtotal'],
            'discount' => $cartData['total']['discount'],
            'vat' => $cartData['total']['vat'],
            'service_tax' => $cartData['total']['service_tax'],
            'tabby_fee' => $totalData['tabby_fee'],
            'total' => $totalData['final_total'],
            'coupon_id' => !empty($cartData['applied_coupons']) ? $cartData['applied_coupons'][0]['id'] ?? null : null,
            'coupon_code' => !empty($cartData['applied_coupons']) ? $cartData['applied_coupons'][0]['code'] ?? null : null,
            'coupon_discount' => $cartData['total']['discount'],
            'status' => 'pending',
        ]);
    }

    private function createOrderItems(Order $order, array $cartData): array
    {
        $tours = Tour::whereIn('id', array_keys($cartData['tours']))->get()->keyBy('id');
        $prioTicketItems = [];

        foreach ($cartData['tours'] as $tourId => $cartItem) {
            $tour = $tours->get($tourId);

            if (!$tour) {
                continue;
            }

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'tour_id' => $tour->id,
                'user_id' => auth()->id() ?? null, // null for guests
                'guest_email' => auth()->check() ? null : $order->passenger_email,
                'tour_name' => $tour->name,
                'booking_date' => $cartItem['date'],
                'time_slot' => $cartItem['time_slot'],
                'price' => $cartItem['total_price'],
                'quantity' => $cartItem['total_pax'],
                'subtotal' => $cartItem['total_price'],
                'pax_details' => $cartItem['pax'],
                'product_id_prio' => $cartItem['product_id_prio'] ?? null,
                'availability_id' => $cartItem['availability_id'] ?? null,
                'status' => 'pending',
            ]);

            if (!empty($cartItem['product_id_prio']) && !empty($cartItem['availability_id'])) {
                $prioTicketItems[] = [
                    'order_item_id' => $orderItem->id,
                    'tour_id' => $tour->id,
                    'product_id_prio' => $cartItem['product_id_prio'],
                    'availability_id' => $cartItem['availability_id'],
                    'product_type_details' => $cartItem['product_type_details'] ?? [],
                ];
            }
        }

        return $prioTicketItems;
    }

    private function processPrioTicketReservation(Order $order, array $prioTicketItems, array $passengerData): void
    {
        if (empty($prioTicketItems)) {
            return;
        }

        $prioService = new PrioTicketService();
        $accessToken = $prioService->getAccessToken();

        if (!$accessToken) {
            return;
        }

        $reservationPayload = $prioService->buildReservationPayload(
            $order,
            $prioTicketItems,
            [
                'first_name' => $passengerData['first_name'],
                'last_name' => $passengerData['last_name'],
                'email' => $passengerData['email'],
                'phone' => $passengerData['phone'],
                'address' => $passengerData['address'],
                'country_code' => $passengerData['country'],
            ]
        );

        $reservationResponse = $prioService->createReservation($reservationPayload, $accessToken);

        if ($reservationResponse['success']) {
            $this->updateOrderWithReservation($order, $reservationResponse, $prioTicketItems);
        } else {
            Log::error('PrioTicket reservation failed', [
                'order_id' => $order->id,
                'error' => $reservationResponse['error']
            ]);
        }
    }

    private function updateOrderWithReservation(Order $order, array $reservationResponse, array $prioTicketItems): void
    {
        $order->update([
            'reservation_reference' => $reservationResponse['data']['data']['reservation']['reservation_reference'] ?? null,
            'reservation_data' => json_encode($reservationResponse['data']),
        ]);

        if (isset($reservationResponse['data']['data']['reservation']['reservation_details'])) {
            foreach ($reservationResponse['data']['data']['reservation']['reservation_details'] as $index => $detail) {
                if (isset($prioTicketItems[$index])) {
                    OrderItem::where('id', $prioTicketItems[$index]['order_item_id'])
                        ->update([
                            'booking_reference' => $detail['booking_reference'] ?? null,
                            'reservation_response' => json_encode($detail),
                            'status' => 'confirmed',
                        ]);
                }
            }
        }
    }

    private function validateCouponUsage(array $appliedCoupons, string $email): array
    {
        foreach ($appliedCoupons as $coupon) {
            if (!$this->canUseCoupon($email, $coupon['id'])) {
                // Remove the already-used coupon from cart
                $cartData = $this->getCartData();
                $cartData['applied_coupons'] = array_filter(
                    $cartData['applied_coupons'],
                    fn($c) => $c['id'] !== $coupon['id']
                );
                $cartData['applied_coupons'] = array_values($cartData['applied_coupons']);

                // Recalculate totals without the invalid coupon
                $this->recalculateCartTotals($cartData);
                session()->put('cart', $cartData);

                return [
                    'valid' => false,
                    'message' => "The coupon '{$coupon['code']}' has already been used with this email address and has been removed from your cart."
                ];
            }
        }

        return ['valid' => true];
    }

    private function recalculateCartTotals(&$cartData): void
    {
        $subtotal = collect($cartData['tours'] ?? [])->sum('total_price');

        $totalDiscount = 0;
        $runningTotal = $subtotal;

        $cartData['applied_coupons'] = $cartData['applied_coupons'] ?? [];

        foreach ($cartData['applied_coupons'] as &$coupon) {
            $discount = 0;
            if ($coupon['type'] === 'percentage') {
                $discount = ($coupon['rate'] / 100) * $runningTotal;
            } elseif ($coupon['type'] === 'amount') {
                $discount = min($coupon['rate'], $runningTotal);
            }

            $coupon['discount'] = $discount;
            $totalDiscount += $discount;
            $runningTotal -= $discount;
        }

        $config = \Illuminate\Support\Facades\View::shared('config', []);
        $vatPercentage = floatval($config['VAT_PERCENTAGE'] ?? 0);
        $serviceTaxPercentage = floatval($config['SERVICE_TAX_PERCENTAGE'] ?? 0);

        $vat = ($vatPercentage / 100) * $runningTotal;
        $serviceTax = ($serviceTaxPercentage / 100) * $runningTotal;
        $totalTax = $vat + $serviceTax;

        $grandTotal = max($runningTotal + $totalTax, 0);

        $cartData['total'] = [
            'subtotal' => $subtotal,
            'discount' => $totalDiscount,
            'vat' => $vat,
            'service_tax' => $serviceTax,
            'tax' => $totalTax,
            'grand_total' => $grandTotal,
        ];
    }

    private function trackCouponUsage(Order $order, string $email): void
    {
        if ($order->coupon_id) {
            UserCoupon::create([
                'email' => $email,
                'coupon_id' => $order->coupon_id,
            ]);
        }
    }

    public function canUseCoupon(string $email, int $couponId): bool
    {
        return !UserCoupon::where('email', $email)
            ->where('coupon_id', $couponId)
            ->exists();
    }
}

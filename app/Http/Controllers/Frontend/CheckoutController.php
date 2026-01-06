<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tour;
use App\Models\Country;
use App\Models\UserCoupon;
use App\Services\PrioTicketService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{

    protected $adminEmail;
    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->adminEmail = $config['ADMINEMAIL'] ?? 'info@andaleebtours.com';
    }

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
            'payment_method' => 'required|in:payby,tabby',
        ]);

        $cartData = $this->getCartData();

        if (empty($cartData['tours'])) {
            return redirect()->route('frontend.cart.index')
                ->with('notify_error', 'Your cart is empty.');
        }


        $availabilityCheck = $this->validateCartAvailability($cartData);
        if (! $availabilityCheck['valid']) {
            session()->forget('cart');
            return redirect()
                ->route('frontend.cart.index')
                ->with('notify_error', $availabilityCheck['message']);
        }

        DB::beginTransaction();

        // Validate coupon usage before creating order
        if (!empty($cartData['applied_coupons'])) {
            $couponValidation = $this->validateCouponUsage(
                $cartData['applied_coupons'],
                $request->passenger['email']
            );
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

            $this->sendOrderCreatedEmails($order);

            $paymentService = new PaymentService();
            $redirectUrl = $paymentService->getRedirectUrl($order, $request->payment_method);

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('frontend.checkout.index')
                ->with('notify_error', $e->getMessage());
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
        // Generate unique PrioTicket booking reference
        $prioReference = 'PRIO-' . strtoupper(uniqid()) . '-' . time();

        return Order::create([
            'user_id' => auth()->id(), // null for guests
            'order_number' => Order::generateOrderNumber(),
            'prio_booking_reference' => $prioReference,
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
            'applied_coupons' => $cartData['applied_coupons'] ?? [],
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

            $productTypeDetails = [];

            foreach ($cartItem['pax'] as $pax) {
                $productTypeDetails[] = [
                    'product_type_id' => $pax['product_type_id'],
                    'product_type_count' => $pax['qty'],
                ];
            }

            if (!empty($cartItem['product_id_prio']) && !empty($cartItem['availability_id'])) {
                $prioTicketItems[] = [
                    'order_item_id' => $orderItem->id,
                    'tour_id' => $tour->id,
                    'product_id_prio' => $cartItem['product_id_prio'],
                    'availability_id' => $cartItem['availability_id'],
                    'product_type_details' => $productTypeDetails,
                ];
            }
        }

        return $prioTicketItems;
    }

    private function processPrioTicketReservation(
        Order $order,
        array $prioTicketItems,
        array $passengerData
    ): void {
        if (empty($prioTicketItems)) {
            return;
        }

        $prioService = new PrioTicketService();
        $accessToken = $prioService->getAccessToken();

        if (! $accessToken) {
            Log::error('PrioTicket: Access token missing', [
                'order_id' => $order->id
            ]);
            throw new \Exception('Unable to connect to booking system. Please try again later.');
        }

        // VALIDATE PRODUCTS
        foreach ($prioTicketItems as $item) {
            $productResponse = $prioService->fetchProduct(
                $item['product_id_prio'],
                $accessToken
            );
            $product = $productResponse['data']['product'] ?? null;

            if (! $product) {
                Log::error('PrioTicket: Product missing in response', [
                    'order_id' => $order->id,
                    'product_id' => $item['product_id_prio'],
                ]);
                throw new \Exception('One or more tours in your cart are no longer available. Please refresh and try again.');
            }

            if (($product['product_status'] ?? null) !== 'ACTIVE') {
                Log::error('PrioTicket: Product not active', [
                    'order_id' => $order->id,
                    'product_id' => $item['product_id_prio'],
                    'status' => $product['product_status'] ?? null,
                ]);
                throw new \Exception('One or more tours in your cart are no longer available. Please refresh and try again.');
            }
        }

        // BUILD RESERVATION PAYLOAD
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
                'city' => $passengerData['city'] ?? null,
                'region' => $passengerData['region'] ?? null,
                'postal_code' => $passengerData['postal_code'] ?? null,
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

        // Throw exception with user-friendly error message
        throw new \Exception($reservationResponse['error'] ?? 'Unable to create reservation. Please try again.');
    }

    private function validateCartAvailability(array $cartData): array
    {
        $prioService = new PrioTicketService();
        $accessToken = $prioService->getAccessToken();

        if (! $accessToken) {
            return [
                'valid' => false,
                'message' => 'Unable to verify availability at the moment',
            ];
        }

        foreach ($cartData['tours'] as $item) {
            // Get tour to check has_capacity flag
            $tour = Tour::where('slug', $item['slug'])->first();
            $hasCapacity = $tour ? $tour->has_capacity : true;

            $result = $prioService->checkAvailability(
                $item['product_id_prio'],
                $item['availability_id'],
                $item['date'],
                $item['total_pax'],
                $accessToken,
                $hasCapacity
            );

            if (! $result['success']) {
                return [
                    'valid' => false,
                    'message' => "{$item['name']} is no longer available. Please update your cart.",
                ];
            }
        }

        return ['valid' => true];
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
                    OrderItem::where('id', $prioTicketItems[$index]['order_item_id'])
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
        if (!empty($order->applied_coupons)) {
            foreach ($order->applied_coupons as $coupon) {
                if (isset($coupon['id'])) {
                    UserCoupon::create([
                        'email' => $email,
                        'coupon_id' => $coupon['id'],
                    ]);
                }
            }
        }
    }

    public function canUseCoupon(string $email, int $couponId): bool
    {
        return !UserCoupon::where('email', $email)
            ->where('coupon_id', $couponId)
            ->exists();
    }

    public function paymentSuccess(Request $request)
    {
        try {
            // Fetch the order with items
            $order = Order::with('orderItems.tour')->findOrFail($request->query('order'));

            if ($order->payment_status === 'paid') {
                return redirect()->route('frontend.index');
            }

            $paymentService = new PaymentService();

            switch ($order->payment_method) {
                case 'payby':
                    $result = $paymentService->verifyPayByPayment($order);

                    if ($result['success']) {
                        return $this->handlePaymentSuccess($order, $result['data']);
                    }

                    return $this->handlePaymentFailure(
                        $order,
                        'PayBy Payment Verification Failed',
                        'We could not verify your PayBy payment.',
                        $result['error']
                    );

                case 'tabby':
                    $result = $paymentService->verifyTabbyPayment($order);

                    if ($result['success']) {
                        return $this->handlePaymentSuccess($order, $result['data']);
                    }

                    return $this->handlePaymentFailure(
                        $order,
                        'Tabby Payment Verification Failed',
                        'We could not verify your Tabby payment.',
                        $result['error']
                    );

                default:
                    return redirect()->route('frontend.payment.failed')
                        ->with('error_title', 'Invalid Payment Method')
                        ->with('error_description', 'The payment method for this order is not recognized.')
                        ->with('error_message', 'Payment method: ' . $order->payment_method);
            }
        } catch (\Exception $e) {
            Log::error('Payment Success Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->handlePaymentFailure(
                $order ?? null,
                'Payment Verification Failed',
                'We could not verify your payment at this time.',
                $e->getMessage()
            );
        }
    }

    protected function handlePaymentSuccess(Order $order, array $paymentData)
    {
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'payment_response' => json_encode($paymentData)
        ]);

        $order->orderItems()->update([
            'status' => 'confirmed'
        ]);

        // Process Prio order confirmation
        $prioResult = $this->processPrioTicketOrder($order);

        // If Prio order confirmation failed, show failure page
        if ($prioResult && !$prioResult['success']) {
            return $this->handlePaymentFailure(
                $order,
                'Booking Confirmation Failed',
                'Your payment was successful, but we could not confirm your booking with our provider.',
                $prioResult['error'] ?? 'Unable to confirm booking. Our team has been notified and will contact you shortly.'
            );
        }

        $this->sendPaymentSuccessEmails($order);

        session()->forget('cart');

        return view('frontend.payment.success', compact('order'));
    }

    protected function handlePaymentFailure(?Order $order, string $title, string $description, string $message)
    {
        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'failed',
                'payment_response' => json_encode([
                    'error_message' => $message,
                    'error_description' => $description,
                    'error_title' => $title,
                    'updated_at' => now()
                ])
            ]);

            // Update order items as failed
            $order->orderItems()->update([
                'status' => 'failed'
            ]);

            $this->sendPaymentFailedEmails($order);
        }

        return redirect()
            ->route('frontend.payment.failed')
            ->with('error_title', $title)
            ->with('error_description', $description)
            ->with('error_message', $message)
            ->with('notify_error', $message);
    }


    protected function processPrioTicketOrder(Order $order)
    {
        $prioTicketService = new PrioTicketService();
        $result = $prioTicketService->confirmOrder($order);

        if (!$result['success']) {
            $this->sendPrioOrderFailedEmail($order, $result['error'] ?? 'Unknown error');
        } else {
            $this->sendBookingConfirmedEmail($order);
        }

        return $result;
    }

    protected function sendOrderCreatedEmails(Order $order)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.order-created-admin', ['order' => $order], function ($message) use ($order) {
                $message->to($this->adminEmail)
                    ->subject('New Order Received - ' . $order->order_number);
            });

            Mail::send('emails.order-created-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Order Received - ' . $order->order_number);
            });

            Log::info('Order created emails sent successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send order created emails', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function sendPaymentSuccessEmails(Order $order)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.payment-success-admin', ['order' => $order], function ($message) use ($order) {
                $message->to($this->adminEmail)
                    ->subject('Payment Successful - ' . $order->order_number);
            });

            Mail::send('emails.payment-success-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Payment Successful - ' . $order->order_number);
            });

            Log::info('Payment success emails sent successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment success emails', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function sendPaymentFailedEmails(Order $order)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.payment-failed-admin', ['order' => $order], function ($message) use ($order) {
                $message->to($this->adminEmail)
                    ->subject('Payment Failed - ' . $order->order_number);
            });

            Mail::send('emails.payment-failed-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Payment Failed - ' . $order->order_number);
            });

            Log::info('Payment failed emails sent successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment failed emails', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function sendPrioOrderFailedEmail(Order $order, string $errorDetails)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.prio-order-failed-admin', [
                'order' => $order,
                'errorDetails' => $errorDetails
            ], function ($message) use ($order) {
                $message->to($this->adminEmail)
                    ->subject('⚠️ URGENT: Prio Order Failed - ' . $order->order_number);
            });

            Log::info('Prio order failed email sent to admin', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $errorDetails
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send Prio order failed email', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function sendBookingConfirmedEmail(Order $order)
    {
        try {
            $order->load('orderItems');

            Mail::send('emails.booking-confirmed-user', ['order' => $order], function ($message) use ($order) {
                $message->to($order->passenger_email)
                    ->subject('Booking Confirmed - ' . $order->order_number);
            });

            Log::info('Booking confirmation email sent to customer', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_email' => $order->passenger_email
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send booking confirmation email', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function paymentFailed()
    {
        return view('frontend.payment.failed');
    }
}

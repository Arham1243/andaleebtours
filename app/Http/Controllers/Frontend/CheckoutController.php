<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tour;
use App\Models\Country;
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
                ->with('notify_error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Calculate Tabby fee if applicable
            $tabbyFee = 0;
            $finalTotal = $cartData['total']['grand_total'];

            if ($request->payment_method === 'tabby') {
                $tabbyFee = $finalTotal * 0.08;
                $finalTotal += $tabbyFee;
            }

            // Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
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
                'tabby_fee' => $tabbyFee,
                'total' => $finalTotal,
                'coupon_id' => !empty($cartData['applied_coupons']) ? $cartData['applied_coupons'][0]['id'] ?? null : null,
                'coupon_code' => !empty($cartData['applied_coupons']) ? $cartData['applied_coupons'][0]['code'] ?? null : null,
                'coupon_discount' => $cartData['total']['discount'],
                'status' => 'pending',
            ]);

            // Get tours from database
            $tours = Tour::whereIn('id', array_keys($cartData['tours']))->get()->keyBy('id');

            // Prepare order items for PrioTicket
            $prioTicketItems = [];

            foreach ($cartData['tours'] as $tourId => $cartItem) {
                $tour = $tours->get($tourId);

                if (!$tour) {
                    continue;
                }

                // Create Order Item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'tour_id' => $tour->id,
                    'user_id' => auth()->id(),
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

                // Prepare for PrioTicket API
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

            // Integrate with PrioTicket API
            if (!empty($prioTicketItems)) {
                $prioService = new PrioTicketService();
                $accessToken = $prioService->getAccessToken();

                if ($accessToken) {
                    $passengerData = [
                        'first_name' => $request->passenger['first_name'],
                        'last_name' => $request->passenger['last_name'],
                        'email' => $request->passenger['email'],
                        'phone' => $request->passenger['phone'],
                        'address' => $request->passenger['address'],
                        'country_code' => $request->passenger['country'],
                    ];

                    $reservationPayload = $prioService->buildReservationPayload(
                        $order,
                        $prioTicketItems,
                        $passengerData
                    );

                    $reservationResponse = $prioService->createReservation(
                        $reservationPayload,
                        $accessToken
                    );

                    if ($reservationResponse['success']) {
                        // Update order with reservation data
                        $order->update([
                            'reservation_reference' => $reservationResponse['data']['data']['reservation']['reservation_reference'] ?? null,
                            'reservation_data' => json_encode($reservationResponse['data']),
                        ]);

                        // Update order items with booking references
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
                    } else {
                        Log::error('PrioTicket reservation failed', [
                            'order_id' => $order->id,
                            'error' => $reservationResponse['error']
                        ]);
                    }
                }
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Store order number in session for success page
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
}

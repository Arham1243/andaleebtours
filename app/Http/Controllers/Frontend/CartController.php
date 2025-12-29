<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\UserCoupon;

class CartController extends Controller
{
    public function index()
    {
        $cartData = $this->getCartData();
        $tours = Tour::whereIn('id', array_keys($cartData['tours'] ?? []))->get();

        return view('frontend.cart.index', compact('cartData', 'tours'));
    }

    public function add(Request $request, $slug)
    {
        $request->validate([
            'start_date' => 'required',
            'time_slot' => 'required',
        ]);

        $tour = Tour::where('slug', $slug)->firstOrFail();
        $bookingDate = Carbon::createFromFormat('M d, Y', $request->start_date)
            ->format('Y-m-d');

        $cartData = $this->getCartData();

        $paxData = [];
        $totalPax = 0;
        $totalPrice = 0;

        foreach ($tour->product_type_seasons[0]['product_type_season_details'] as $type) {

            $label = strtolower($type['product_type_label']);
            $qtyKey = $label . '_qty';
            $qty = (int) $request->input($qtyKey, 0);

            if ($qty <= 0) {
                continue;
            }

            $priceField = strtolower($type['product_type']);
            $price = $tour->{$priceField . '_price'}
                ?? $type['product_type_pricing']['product_type_sales_price'];

            $subtotal = $qty * $price;

            $paxData[$label] = [
                'label' => $type['product_type_label'],
                'qty' => $qty,
                'price' => $price,
                'subtotal' => $subtotal,
            ];

            $totalPax += $qty;
            $totalPrice += $subtotal;
        }

        if ($totalPax === 0) {
            return back()->withErrors('Please select at least one pax');
        }

        $cartData['tours'][$tour->id] = [
            'tour_id' => $tour->id,
            'slug' => $tour->slug,
            'name' => $tour->name,
            'date' => $bookingDate,
            'time_slot' => $request->time_slot_display ?? $request->time_slot,
            'availability_id' => $request->time_slot,
            'pax' => $paxData,
            'total_pax' => $totalPax,
            'total_price' => $totalPrice,
        ];

        $this->recalculateCartTotals($cartData);

        session()->put('cart', $cartData);

        return redirect()
            ->route('frontend.cart.index')
            ->with('notify_success', 'Tour added to cart');
    }

    public function updateQuantity(Request $request, $slug)
    {
        $request->validate([
            'pax_type' => 'required|string',
            'qty' => 'required|integer|min:1',
        ]);

        $tour = Tour::where('slug', $slug)->first();

        if (!$tour) {
            return response()->json(['success' => false, 'message' => 'Tour not found.'], 404);
        }

        $cartData = $this->getCartData();

        if (!isset($cartData['tours'][$tour->id]['pax'][$request->pax_type])) {
            return response()->json(['success' => false, 'message' => 'Item not in cart.'], 404);
        }

        $cartData['tours'][$tour->id]['pax'][$request->pax_type]['qty'] = $request->qty;
        $cartData['tours'][$tour->id]['pax'][$request->pax_type]['subtotal'] =
            $request->qty * $cartData['tours'][$tour->id]['pax'][$request->pax_type]['price'];

        $cartData['tours'][$tour->id]['total_pax'] = collect($cartData['tours'][$tour->id]['pax'])->sum('qty');
        $cartData['tours'][$tour->id]['total_price'] = collect($cartData['tours'][$tour->id]['pax'])->sum('subtotal');

        $this->recalculateCartTotals($cartData);

        session()->put('cart', $cartData);

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully.',
            'data' => [
                'qty' => $request->qty,
                'item_subtotal' => $cartData['tours'][$tour->id]['pax'][$request->pax_type]['subtotal'],
                'cart_subtotal' => $cartData['total']['subtotal'],
                'cart_grand_total' => $cartData['total']['grand_total'],
            ]
        ]);
    }

    public function remove(Request $request, $slug)
    {
        $request->validate([
            'pax_type' => 'required|string',
        ]);

        $tour = Tour::where('slug', $slug)->first();

        if (!$tour) {
            return back()->with('notify_error', 'Tour not found.');
        }

        $cartData = $this->getCartData();

        if (isset($cartData['tours'][$tour->id]['pax'][$request->pax_type])) {
            unset($cartData['tours'][$tour->id]['pax'][$request->pax_type]);

            $cartData['tours'][$tour->id]['total_pax'] = collect($cartData['tours'][$tour->id]['pax'])->sum('qty');
            $cartData['tours'][$tour->id]['total_price'] = collect($cartData['tours'][$tour->id]['pax'])->sum('subtotal');

            if ($cartData['tours'][$tour->id]['total_pax'] === 0) {
                unset($cartData['tours'][$tour->id]);
            }

            if (empty($cartData['tours'])) {
                $cartData['applied_coupons'] = [];
            }

            $this->recalculateCartTotals($cartData);

            session()->put('cart', $cartData);

            return back()->with('notify_success', 'Item removed from cart.');
        }

        return back()->with('notify_error', 'Tour was not in the cart.');
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $couponCode = strtoupper($request->coupon_code);

        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->first();

        if (!$coupon) {
            return back()->with('notify_error', 'Invalid or inactive coupon.');
        }

        $cartData = $this->getCartData();

        if (empty($cartData['tours'])) {
            return back()->with('notify_error', 'Your cart is empty.');
        }

        // Check if user is logged in and validate against database
        if (auth()->check()) {
            $userEmail = auth()->user()->email;
            
            // Check if user already used this coupon in database
            if (!$this->canUseCoupon($userEmail, $coupon->id)) {
                return back()->with('notify_error', 'You have already used this coupon previously.');
            }
        }

        // Check if coupon already applied in current session
        if (collect($cartData['applied_coupons'])->pluck('code')->contains($couponCode)) {
            return back()->with('notify_error', 'Coupon already applied to your cart.');
        }

        $cartSubtotal = collect($cartData['tours'])->sum('total_price');
        $currentTotal = $cartData['total']['grand_total'] ?? $cartSubtotal;

        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($coupon->rate / 100) * $currentTotal;
        } elseif ($coupon->type === 'amount') {
            $discount = min($coupon->rate, $currentTotal);
        }

        $cartData['applied_coupons'][] = [
            'id' => $coupon->id,
            'code' => $couponCode,
            'type' => $coupon->type,
            'rate' => $coupon->rate,
            'discount' => $discount,
        ];

        $this->recalculateCartTotals($cartData);

        session()->put('cart', $cartData);

        return back()->with("notify_success", "Coupon applied! Discount: AED " . number_format($discount, 2));
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

    public function canUseCoupon(string $email, int $couponId): bool
    {
        return !UserCoupon::where('email', $email)
            ->where('coupon_id', $couponId)
            ->exists();
    }

    private function recalculateCartTotals(&$cartData)
    {
        $subtotal = collect($cartData['tours'] ?? [])->sum('total_price');

        $totalDiscount = 0;
        $runningTotal = $subtotal;

        // Ensure applied_coupons is always an array
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

        // Calculate taxes from shared config
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
}

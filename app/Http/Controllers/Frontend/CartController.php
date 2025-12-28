<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        // session()->forget('cart');
        $cart = session()->get('cart', []);
        $tours = Tour::whereIn('id', array_column($cart, 'tour_id'))->get();
        $grandTotal = collect($cart)->sum('total_price');
        $totalPax = collect($cart)->sum('total_pax');
        $subtotal = collect($cart)->sum('total_price');
        return view('frontend.cart.index', compact('cart', 'grandTotal', 'totalPax', 'tours', 'subtotal'));
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

        $cart = session()->get('cart', []);

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

        // Cart key is ONLY tour_id
        $cart[$tour->id] = [
            'tour_id' => $tour->id,
            'slug' => $tour->slug,
            'name' => $tour->name,
            'date' => $bookingDate,
            'time_slot' => $request->time_slot,
            'pax' => $paxData,
            'total_pax' => $totalPax,
            'total_price' => $totalPrice,
        ];

        session()->put('cart', $cart);

        return redirect()
            ->route('frontend.cart.index')
            ->with('notify_success', 'Tour added to cart');
    }

    public function remove(Request $request, $slug)
    {
        $request->validate([
            'pax_type' => 'required|string',
        ]);
        // Find tour by slug
        $tour = Tour::where('slug', $slug)->first();

        if (!$tour) {
            return back()->with('notify_error', 'Tour not found.');
        }

        // Get current cart
        $cart = session()->get('cart', []);
        // Remove tour if it exists
        if (isset($cart[$tour->id]['pax'][$request->pax_type])) {
            unset($cart[$tour->id]['pax'][$request->pax_type]);

            // Recalculate totals
            $cart[$tour->id]['total_pax'] = collect($cart[$tour->id]['pax'])->sum('qty');
            $cart[$tour->id]['total_price'] = collect($cart[$tour->id]['pax'])->sum('subtotal');

            // Remove the tour if no pax left
            if ($cart[$tour->id]['total_pax'] === 0) {
                unset($cart[$tour->id]);
            }

            session()->put('cart', $cart);

            return back()->with('notify_success', 'Item removed from cart.');
        }


        return back()->with('notify_error', 'Tour was not in the cart.');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartData = session('cartData', []);

        if (empty($cartData['tours'] ?? [])) {
            return redirect()->route('frontend.cart.index')
                ->with('notify_error', 'Your cart is empty. Please add some tours before checkout.');
        }

        return view('frontend.checkout.index', compact('cartData'));
    }
}

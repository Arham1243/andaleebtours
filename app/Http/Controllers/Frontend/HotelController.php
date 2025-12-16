<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function index()
    {
        return view('frontend.hotels.index');
    }

    public function search()
    {
        return view('frontend.hotels.search');
    }

    public function details()
    {
        return view('frontend.hotels.details');
    }

    public function checkout()
    {
        return view('frontend.hotels.checkout');
    }
}

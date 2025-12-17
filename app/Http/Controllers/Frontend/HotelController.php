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
        $is_extras = false;
        $data = compact('is_extras');
        return view('frontend.hotels.checkout')->with($data);
    }

    public function extras()
    {
        $is_extras = true;
        $data = compact('is_extras');
        return view('frontend.hotels.checkout')->with($data);
    }
}

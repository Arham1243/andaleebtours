<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class HotelController extends Controller
{
    public function index()
    {
        $banner = Banner::where('page', 'hotels-listing')->where('status', 'active')->first();
        return view('frontend.hotels.index', compact('banner'));
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

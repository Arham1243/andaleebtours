<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class TourController extends Controller
{
    public function uae_services()
    {
        $banner = Banner::where('page', 'uae-tours')->where('status', 'active')->first();
        return view('frontend.tour.uae-services', compact('banner'));
    }

    public function details()
    {
        return view('frontend.tour.details');
    }
}

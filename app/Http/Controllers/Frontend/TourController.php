<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TourCategory;
use App\Models\PackageCategory;
use App\Models\Tour;

class TourController extends Controller
{
    public function uae_services()
    {
        $search = request('search') ?? '';
        $banner = Banner::where('page', 'uae-tours')->where('status', 'active')->first();
        $categories = TourCategory::where('status', 'active')->latest()->get();
        $tours = Tour::where('status', 'active')->where('name', 'like', '%' . $search . '%')->latest()->get();
        $packageCategories = PackageCategory::with('packages')
            ->where('status', 'active')
            ->has('packages')
            ->latest()
            ->get();
        return view('frontend.tour.uae-services', compact('banner', 'categories', 'tours', 'packageCategories'));
    }

    public function details()
    {
        return view('frontend.tour.details');
    }
}

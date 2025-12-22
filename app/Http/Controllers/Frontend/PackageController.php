<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class PackageController extends Controller
{
    public function index()
    {
        $banner = Banner::where('page', 'packages')->where('status', 'active')->first();
        return view('frontend.packages.index', compact('banner'));
    }
    public function category()
    {
        return view('frontend.packages.category');
    }
    public function details()
    {
        $banner = Banner::where('page', 'packages-details')->where('status', 'active')->first();
        return view('frontend.packages.details', compact('banner'));
    }
}

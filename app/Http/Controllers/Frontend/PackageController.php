<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Package;
use App\Models\PackageCategory;

class PackageController extends Controller
{
    public function index()
    {
        $banner = Banner::where('page', 'packages')->where('status', 'active')->first();
        $categories = PackageCategory::where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.packages.index', compact('banner', 'categories'));
    }

    public function category($slug)
    {
        $banner = Banner::where('page', 'packages-category')->where('status', 'active')->first();
        $category = PackageCategory::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $packages = Package::where('package_category_id', $category->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('frontend.packages.category', compact('category', 'packages', 'banner'));
    }
    
    public function details()
    {
        $banner = Banner::where('page', 'packages-details')->where('status', 'active')->first();
        return view('frontend.packages.details', compact('banner'));
    }
}

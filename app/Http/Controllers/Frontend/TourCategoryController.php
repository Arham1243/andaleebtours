<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class TourCategoryController extends Controller
{
    public function index()
    {
        $banner = Banner::where('page', 'tour-category')->where('status', 'active')->first();
        return view('frontend.tour-category.index', compact('banner'));
    }
}

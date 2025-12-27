<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TourCategory;

class TourCategoryController extends Controller
{
    public function details($slug)
    {
        $search = request('search') ?? '';
        $category = TourCategory::where('slug', $slug)->first();
        $banner = Banner::where('page', 'tour-category')->where('status', 'active')->first();
        $tours = $category->tours()->where('status', 'active')->where('name', 'like', '%' . $search . '%')->get();
        return view('frontend.tour-category.details', compact('banner', 'category', 'tours'));
    }
}

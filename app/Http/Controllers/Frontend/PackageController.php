<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\PackageInquiry;
use Illuminate\Http\Request;

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

    public function search()
    {
        $search = request('search', '');
        $title = 'Search Packages';
        $packages = Package::where('status', 'active')
            ->where('name', 'like', '%' . $search . '%')
            ->latest()
            ->get();
        return view('frontend.packages.search', compact('title', 'packages'));
    }

    public function details($slug)
    {
        $banner = Banner::where('page', 'packages-details')->where('status', 'active')->first();
        $package = Package::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $packageCategories = PackageCategory::with(['packages' => function ($query) use ($package) {
            $query->where('status', 'active')->where('id', '!=', $package->id);
        }])
            ->where('status', 'active')
            ->latest()
            ->get()
            ->filter(function ($category) {
                return $category->packages->isNotEmpty();
            });
        return view('frontend.packages.details', compact('banner', 'package', 'packageCategories'));
    }

    public function submitInquiry(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'tour_date' => 'nullable|date',
            'pax' => 'nullable|integer|min:1',
            'pickup_location' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        PackageInquiry::create([
            'package_id' => $request->package_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tour_date' => $request->tour_date,
            'pax' => $request->pax,
            'pickup_location' => $request->pickup_location,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('notify_success', 'Your inquiry has been submitted successfully! We will contact you soon.');
    }
}

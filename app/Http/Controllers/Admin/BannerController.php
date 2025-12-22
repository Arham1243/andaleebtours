<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use UploadImageTrait;

    protected $predefinedPages = [
        'home' => 'Home',
        'hotels-listing' => 'Hotels Listing',
        'about-us' => 'About Us',
        'contact-us' => 'Contact Us',
        'uae-tours' => 'UAE Tours',
        'packages' => 'Packages',
        'packages-details' => 'Packages Details',
        'tour-category' => 'Tour Category',
    ];

    public function index()
    {
        $title = 'Manage Banners';
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('admin.banners.list', compact('banners', 'title'));
    }

    public function create()
    {
        $title = 'Add New Banner';
        
        // Get pages that already have banners (excluding 'home')
        $usedPages = Banner::where('page', '!=', 'home')->pluck('page')->toArray();
        
        // Filter out used pages from predefined pages
        $pages = collect($this->predefinedPages)->filter(function($value, $key) use ($usedPages) {
            return !in_array($key, $usedPages);
        })->toArray();
        
        return view('admin.banners.add', compact('title', 'pages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Check if banner already exists for this page (except home)
        if ($request->page !== 'home') {
            $existingBanner = Banner::where('page', $request->page)->first();
            if ($existingBanner) {
                return redirect()->back()->with('notify_error', 'A banner already exists for this page. Only Home page can have multiple banners.');
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'banners');
        }

        Banner::create([
            'page' => $request->page,
            'image' => $imagePath,
            'heading' => $request->heading,
            'paragraph' => $request->paragraph,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('notify_success', 'Banner created successfully!');
    }

    public function edit(Banner $banner)
    {
        $title = 'Edit Banner - ' . $this->predefinedPages[$banner->page];
        $pages = $this->predefinedPages;
        return view('admin.banners.edit', compact('banner', 'title', 'pages'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $banner->image;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'banners', $banner->image);
        }

        $banner->update([
            'image' => $imagePath,
            'heading' => $request->heading,
            'paragraph' => $request->paragraph,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.banners.index')->with('notify_success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            $this->deletePreviousImage($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('notify_success', 'Banner deleted successfully!');
    }

    public function changeStatus(Banner $banner)
    {
        $newStatus = $banner->status === 'active' ? 'inactive' : 'active';
        $banner->update(['status' => $newStatus]);
        return redirect()->route('admin.banners.index')->with('notify_success', 'Banner status changed successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourCategory;
use App\Traits\UploadImageTrait;
use App\Traits\GenerateSlugTrait;
use Illuminate\Http\Request;

class TourCategoryController extends Controller
{
    use UploadImageTrait, GenerateSlugTrait;

    public function index()
    {
        $title = 'Manage Tour Categories';
        $categories = TourCategory::latest()->get();
        return view('admin.tours.categories.list', compact('categories', 'title'));
    }

    public function create()
    {
        $title = 'Add New Tour Category';
        return view('admin.tours.categories.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tour_categories,name',
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Use custom slug if provided, otherwise generate from name
        $slug = $request->filled('slug') 
            ? $this->generateUniqueSlug($request->slug, TourCategory::class)
            : $this->generateUniqueSlug($request->name, TourCategory::class);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'tour-categories');
        }

        TourCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tour-categories.index')->with('notify_success', 'Tour Category created successfully!');
    }

    public function edit(TourCategory $tourCategory)
    {
        $title = 'Edit Tour Category - ' . $tourCategory->name;
        return view('admin.tours.categories.edit', compact('tourCategory', 'title'));
    }

    public function update(Request $request, TourCategory $tourCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tour_categories,name,' . $tourCategory->id,
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Use custom slug if provided, otherwise generate from name
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug($request->slug, TourCategory::class, 'slug', $tourCategory->id)
            : $this->generateUniqueSlug($request->name, TourCategory::class, 'slug', $tourCategory->id);

        $imagePath = $tourCategory->image;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'tour-categories', $tourCategory->image);
        }

        $tourCategory->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tour-categories.index')->with('notify_success', 'Tour Category updated successfully!');
    }

    public function destroy(TourCategory $tourCategory)
    {
        $tourCategory->delete();
        return redirect()->route('admin.tour-categories.index')->with('notify_success', 'Tour Category deleted successfully!');
    }

    public function changeStatus(TourCategory $tourCategory)
    {
        $newStatus = $tourCategory->status === 'active' ? 'inactive' : 'active';
        $tourCategory->update(['status' => $newStatus]);
        return redirect()->route('admin.tour-categories.index')->with('notify_success', 'Tour Category status changed successfully!');
    }
}

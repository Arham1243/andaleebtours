<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageCategoryController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $title = 'Manage Package Categories';
        $categories = PackageCategory::orderBy('created_at', 'desc')->get();
        return view('admin.packages.categories.list', compact('categories', 'title'));
    }

    public function create()
    {
        $title = 'Add New Package Category';
        return view('admin.packages.categories.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'short_description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (PackageCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'package-categories');
        }

        PackageCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'is_featured' => $request->has('is_featured') ? true : false,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.package-categories.index')->with('notify_success', 'Package Category created successfully!');
    }

    public function edit(PackageCategory $packageCategory)
    {
        $title = 'Edit Package Category - ' . $packageCategory->name;
        return view('admin.packages.categories.edit', compact('packageCategory', 'title'));
    }

    public function update(Request $request, PackageCategory $packageCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name,' . $packageCategory->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'short_description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (PackageCategory::where('slug', $slug)->where('id', '!=', $packageCategory->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $imagePath = $packageCategory->image;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'package-categories', $packageCategory->image);
        }

        $packageCategory->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'is_featured' => $request->has('is_featured') ? true : false,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.package-categories.index')->with('notify_success', 'Package Category updated successfully!');
    }

    public function destroy(PackageCategory $packageCategory)
    {
        if ($packageCategory->image) {
            $this->deletePreviousImage($packageCategory->image);
        }
        $packageCategory->delete();
        return redirect()->route('admin.package-categories.index')->with('notify_success', 'Package Category deleted successfully!');
    }

    public function changeStatus(PackageCategory $packageCategory)
    {
        $newStatus = $packageCategory->status === 'active' ? 'inactive' : 'active';
        $packageCategory->update(['status' => $newStatus]);
        return redirect()->route('admin.package-categories.index')->with('notify_success', 'Package Category status changed successfully!');
    }
}

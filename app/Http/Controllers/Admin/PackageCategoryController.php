<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use App\Traits\UploadImageTrait;
use App\Traits\GenerateSlugTrait;
use Illuminate\Http\Request;

class PackageCategoryController extends Controller
{
    use UploadImageTrait, GenerateSlugTrait;

    public function index()
    {
        $title = 'Manage Package Categories';
        $categories = PackageCategory::latest()->get();
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
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'short_description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        // Use custom slug if provided, otherwise generate from name
        $slug = $request->filled('slug') 
            ? $this->generateUniqueSlug($request->slug, PackageCategory::class)
            : $this->generateUniqueSlug($request->name, PackageCategory::class);

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
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'short_description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        // Use custom slug if provided, otherwise generate from name
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug($request->slug, PackageCategory::class, 'slug', $packageCategory->id)
            : $this->generateUniqueSlug($request->name, PackageCategory::class, 'slug', $packageCategory->id);

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

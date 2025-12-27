<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use App\Services\TourSyncService;
use App\Traits\GenerateSlugTrait;

class TourController extends Controller
{

    use GenerateSlugTrait;
    public function index()
    {
        $title = 'Manage Tours';
        $tours = Tour::latest()->get();
        return view('admin.tours.list', compact('title', 'tours'));
    }

    public function create()
    {
        $title = 'Add New Tour';
        return view('admin.tours.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributer_name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'discount_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'min_qty' => 'nullable|integer|min:1',
            'max_qty' => 'nullable|integer|min:1',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'cancellation_policies' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'is_recommended' => 'nullable|boolean',
        ]);

        // Mass assignment
        $data = $request->only([
            'distributer_name',
            'type',
            'name',
            'discount_price',
            'price',
            'duration',
            'min_qty',
            'max_qty',
            'short_description',
            'long_description',
            'additional_information',
            'cancellation_policies',
            'status',
        ]);

        // Handle slug
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug($request->slug, Tour::class)
            : $this->generateUniqueSlug($request->name, Tour::class);

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_recommended'] = $request->has('is_recommended') ? 1 : 0;
        $data['slug'] = $slug;

        Tour::create($data);

        return redirect()->route('admin.tours.index')
            ->with('notify_success', 'Tour created successfully!');
    }


    public function sync()
    {
        $title = 'Sync Tours';
        return view('admin.tours.sync', compact('title'));
    }


    public function edit(Tour $tour)
    {
        $title = 'Edit Tour - ' . $tour->name;
        return view('admin.tours.edit', compact('tour', 'title'));
    }


    public function update(Request $request, Tour $tour)
    {
        $request->validate([
            'distributer_name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'discount_price' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'min_qty' => 'nullable|integer|min:1',
            'max_qty' => 'nullable|integer|min:1',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'cancellation_policies' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
            'is_recommended' => 'nullable|boolean',
        ]);

        // Mass assignment
        $data = $request->only([
            'distributer_name',
            'type',
            'name',
            'discount_price',
            'price',
            'duration',
            'min_qty',
            'max_qty',
            'short_description',
            'long_description',
            'additional_information',
            'cancellation_policies',
            'status',
        ]);

        // Handle slug
        $slug = $request->filled('slug')
            ? $this->generateUniqueSlug($request->slug, Tour::class, 'slug', $tour->id)
            : $this->generateUniqueSlug($request->name, Tour::class, 'slug', $tour->id);

        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $data['is_recommended'] = $request->has('is_recommended') ? 1 : 0;
        $data['slug'] = $slug;

        $tour->update($data);

        return redirect()->route('admin.tours.index')
            ->with('notify_success', 'Tour updated successfully!');
    }


    public function changeStatus(Tour $tour)
    {
        $newStatus = $tour->status === 'active' ? 'inactive' : 'active';
        $tour->update(['status' => $newStatus]);
        return redirect()->route('admin.tours.index')->with('notify_success', 'Tour status changed successfully!');
    }

    public function handleSync(Request $request)
    {
        $page = $request->input('page', 1);

        $syncService = new TourSyncService();
        $syncService->syncPrioTicketTours($page);

        return redirect()
            ->route('admin.tours.sync')
            ->with('notify_success', 'Tours synced successfully');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('notify_success', 'Tour deleted successfully!');
    }
}

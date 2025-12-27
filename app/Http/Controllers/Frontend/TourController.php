<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TourCategory;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourReview;

class TourController extends Controller
{
    public function uae_services()
    {
        $search = request('search') ?? '';
        $banner = Banner::where('page', 'uae-tours')->where('status', 'active')->first();
        $categories = TourCategory::where('status', 'active')->latest()->get();
        $tours = Tour::where('status', 'active')->where('name', 'like', '%' . $search . '%')->latest()->get()->take(16);
        $total_tours = Tour::where('status', 'active')->where('name', 'like', '%' . $search . '%')->latest()->get()->count();
        $packageCategories = PackageCategory::with('packages')
            ->where('status', 'active')
            ->has('packages')
            ->latest()
            ->get();
        return view('frontend.tour.uae-services', compact('banner', 'categories', 'tours', 'packageCategories', 'total_tours'));
    }

    public function details($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        $tourCategories = TourCategory::with([
            'tours' => function ($query) use ($tour) {
                $query->where('tours.status', 'active')
                    ->where('tours.id', '!=', $tour->id);
            }
        ])
            ->where('status', 'active')
            ->latest()
            ->get()
            ->filter(fn($category) => $category->tours->isNotEmpty());

        return view('frontend.tour.details', compact('tour', 'tourCategories'));
    }

    public function loadTourBlocks(Request $request)
    {
        $searchQuery = $request->search_query;
        // Make sure we get an array
        $block = is_array($request->block) ? $request->block : json_decode($request->block, true);
        $block = array_filter($block, fn($id) => is_numeric($id)); // keep only numbers

        $limit = (int) $request->limit ?: 8;
        $offset = (int) $request->offset ?: 0;

        $colClass = $request->col_class ?? 'col-md-3';
        $cardStyle = $request->card_style ?? 'style3';

        // IDs already shown
        $excludedIds = array_map('intval', $block);

        // Query tours except already shown
        $toursQuery = Tour::where('status', 'active')
            ->whereNotIn('id', $excludedIds)
            ->where('name', 'like', '%' . $searchQuery . '%');

        // total count of remaining active tours
        $totalTours = $toursQuery->count();

        // apply offset and limit
        $tours = $toursQuery->skip($offset)->take($limit)->get();

        $remainingCount = max($totalTours - ($offset + $tours->count()), 0);

        return response()->json([
            'html' => view('frontend.partials.tour-cards', compact('tours', 'colClass', 'cardStyle'))->render(),
            'count' => $tours->count(),
            'remainingCount' => $remainingCount,
        ]);
    }


    public function saveReview(Request $request, $tourSlug)
    {
        
        $tour = Tour::where('slug', $tourSlug)->firstOrFail();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required',
        ]);
        $validated['tour_id'] = $tour->id;
        $validated['user_id'] = auth()->user()->id;

        TourReview::create($validated);

        return back()->with('notify_success', 'Review Pending For Admin Approval!');
    }
}

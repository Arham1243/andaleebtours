<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\TourCategory;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourReview;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

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
        $date = request('date') ?? now()->format('Y-m-d');

        $tour = Tour::where('slug', $slug)->firstOrFail();
        $availability = $this->checkAvailability($tour, $date);
        $isTourAvailable = $availability['is_available'] ?? true;
        $availableRanges = $availability['available_ranges'] ?? [];
        $timeSlots = [];
        if ($date) {
            $timeSlots = $this->getTimeSlots($tour->distributer_id, $date);
        }

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

        return view('frontend.tour.details', compact('tour', 'tourCategories', 'isTourAvailable', 'availableRanges', 'timeSlots'));
    }


    public function getAccessToken()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic YW5kYWxlZWIyMDIzMDFAcHJpb2FwaXMuY29tOkBBbmQwVHJhdjMkTEAhMiM='
        ])->post('https://distributor-api.prioticket.com/v3.5/distributor/oauth2/token');

        $accessToken = $response->json('access_token');

        if (!$accessToken) {
            return null;
        }

        return $accessToken;
    }


    public function getTimeSlots($tourId, $date)
    {
        $date = $date ?? now()->format('Y-m-d');
        $accessToken = $this->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ])->get("https://distributor-api.prioticket.com/v3.5/distributor/products/{$tourId}/availability?distributor_id=49670&from_date={$date}");

        if ($response->successful()) {
            $data = $response->json();
            $rawSlots = $data['data']['items'] ?? [];

            $formattedSlots = collect($rawSlots)
                ->filter(fn($slot) => $slot['availability_spots']['availability_spots_open'] > 0) 
                ->map(function ($slot) {
                    return [
                        'id' => $slot['availability_id'],
                        'start_time' => \Carbon\Carbon::parse($slot['availability_from_date_time'])->format('h:i A'),
                        'end_time' => \Carbon\Carbon::parse($slot['availability_to_date_time'])->format('h:i A'),
                        'open_spots' => $slot['availability_spots']['availability_spots_open'],
                    ];
                })->toArray();

            return $formattedSlots;
        }

        return [];
    }


    public function checkAvailability($tour, $date = null)
    {
        $requestedDate = $date ? Carbon::parse($date) : null;
        $isAvailable = false;
        $availableRanges = [];

        foreach ($tour->product_type_seasons as $season) {
            $start = Carbon::parse($season['product_type_season_start_date']);
            $end = Carbon::parse($season['product_type_season_end_date']);

            $availableRanges[] = [
                'start' => $start->format('M d, Y'),
                'end' => $end->format('M d, Y'),
            ];

            if ($requestedDate && $requestedDate->between($start, $end)) {
                $isAvailable = true;
            }
        }

        return [
            'is_available' => $isAvailable,
            'available_ranges' => $availableRanges,
        ];
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Province;
use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public $apiKey = '93082895-c45f-489f-ae10-bed9eaae161e';
    public $url = 'https://api.yalago.com/hotels/Inventory/GetLocations';

    public function index()
    {
        $title = 'Manage Locations';
        $locations = Location::latest()->paginate(10);

        return view('admin.hotels.locations.list', compact('locations', 'title'));
    }

    public function create()
    {
        $title = 'Add New Location';

        $countries = Country::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        $provinces = Province::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.hotels.locations.add', compact('title', 'countries', 'provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'country_id'  => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'yalago_id'   => 'required|integer',
            'status'      => 'required|in:active,inactive',
        ]);

        Location::create([
            'name'        => $request->name,
            'country_id'  => $request->country_id,
            'province_id' => $request->province_id,
            'yalago_id'   => $request->yalago_id,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.locations.index')
            ->with('notify_success', 'Location created successfully!');
    }

    public function edit(Location $location)
    {
        $title = 'Edit Location - ' . $location->name;

        $countries = Country::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        $provinces = Province::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'admin.hotels.locations.edit',
            compact('location', 'title', 'countries', 'provinces')
        );
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'country_id'  => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'yalago_id'   => 'required|integer',
            'status'      => 'required|in:active,inactive',
        ]);

        $location->update([
            'name'        => $request->name,
            'country_id'  => $request->country_id,
            'province_id' => $request->province_id,
            'yalago_id'   => $request->yalago_id,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.locations.index')
            ->with('notify_success', 'Location updated successfully!');
    }

    public function sync(Country $country, Province $province)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Connection: keep-alive',
            'Accept' => 'application/json',
        ])->post($this->url, [
            'CountryId'  => $country->yalago_id,
            'ProvinceId' => $province->yalago_id,
        ]);

        if ($response->failed()) {
            return redirect()->back()
                ->with('notify_error', 'Failed to fetch locations from Yalago.');
        }

        $locations = $response->json('Locations', []);
        $newCount = 0;

        foreach ($locations as $loc) {
            $existing = Location::where('yalago_id', $loc['LocationId'])->first();

            $data = [
                'country_id'  => $country->id,
                'province_id' => $province->id,
                'yalago_id'   => $loc['LocationId'],
                'name'        => $loc['Title'],
                'status'      => 'active',
            ];

            if ($existing) {
                $existing->update($data);
            } else {
                Location::create($data);
                $newCount++;
            }
        }

        $this->dumpToJson();

        return redirect()->route('admin.locations.index')
            ->with('notify_success', "{$newCount} Locations synced");
    }

    protected function dumpToJson()
    {
        $locations = Location::with('country', 'province')
            ->get()
            ->sortBy('name')
            ->values()
            ->map(function ($location) {
                return [
                    'id' => $location->id,
                    'name' => $location->name,
                    'country_name' => $location->country->name ?? null,
                    'province_id' => $location->province_id,
                    'province_name' => $location->province->name ?? null,
                ];
            });

        file_put_contents(
            public_path('frontend/mocks/yalago_locations.json'),
            $locations->toJson(JSON_PRETTY_PRINT)
        );
    }
}

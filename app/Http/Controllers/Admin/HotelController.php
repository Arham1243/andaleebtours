<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Province;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HotelController extends Controller
{

    public $apiKey = '93082895-c45f-489f-ae10-bed9eaae161e';
    public $url = 'https://api.yalago.com/hotels/Inventory/GetEstablishments';

    public function index()
    {
        $title = 'Manage Hotels';
        $hotels = Hotel::latest()->get();

        return view('admin.hotels.hotels.list', compact('hotels', 'title'));
    }

    public function create()
    {
        $title = 'Add New Hotel';

        $countries = Country::where('status', 'active')->orderBy('name')->get();
        $provinces = Province::where('status', 'active')->orderBy('name')->get();
        $locations = Location::where('status', 'active')->orderBy('name')->get();

        return view('admin.hotels.hotels.add', compact('title', 'countries', 'provinces', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'country_id'  => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'location_id' => 'required|exists:locations,id',
            'yalago_id'   => 'required|integer',
            'rating'      => 'nullable|numeric',
            'address'     => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:100',
            'longitude' => 'nullable|numeric',
            'geo_code_accuracy' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'summary'     => 'nullable|string',
            'images'      => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        Hotel::create($request->only([
            'name',
            'country_id',
            'province_id',
            'location_id',
            'yalago_id',
            'rating',
            'address',
            'postal_code',
            'phone',
            'email',
            'longitude',
            'latitude',
            'geo_code_accuracy',
            'description',
            'summary',
            'images',
            'status'
        ]));

        return redirect()
            ->route('admin.hotels.index')
            ->with('notify_success', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel)
    {
        $title = 'Edit Hotel - ' . $hotel->name;

        $countries = Country::where('status', 'active')->orderBy('name')->get();
        $provinces = Province::where('status', 'active')->orderBy('name')->get();
        $locations = Location::where('status', 'active')->orderBy('name')->get();

        return view('admin.hotels.hotels.edit', compact('hotel', 'title', 'countries', 'provinces', 'locations'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'country_id'  => 'required|exists:countries,id',
            'province_id' => 'required|exists:provinces,id',
            'location_id' => 'required|exists:locations,id',
            'yalago_id'   => 'required|integer',
            'rating'      => 'nullable|numeric',
            'address'     => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'phone'       => 'nullable|string|max:50',
            'email'       => 'nullable|email|max:100',
            'latitude' => 'nullable|numeric',
            'geo_code_accuracy' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'summary'     => 'nullable|string',
            'images'      => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $hotel->update($request->only([
            'name',
            'country_id',
            'province_id',
            'location_id',
            'yalago_id',
            'rating',
            'address',
            'postal_code',
            'phone',
            'email',
            'longitude',
            'latitude',
            'geo_code_accuracy',
            'description',
            'summary',
            'images',
            'status'
        ]));

        return redirect()
            ->route('admin.hotels.index')
            ->with('notify_success', 'Hotel updated successfully!');
    }

    public function sync(Country $country, Province $province, Location $location)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Connection' => 'keep-alive',
            'Accept' => 'application/json',
        ])->post($this->url, [
            'CountryId'  => $country->yalago_id,
            'ProvinceId' => $province->yalago_id,
            'LocationId' => $location->yalago_id,
            'Languages'  => ['en', 'es'],
        ]);

        if ($response->failed()) {
            return redirect()->back()
                ->with('notify_error', 'Failed to fetch hotels from Yalago.');
        }

        $hotels = $response->json('Establishments', []);
        $newCount = 0;

        foreach ($hotels as $h) {
            $hotelData = [
                'country_id'        => $country->id,
                'province_id'       => $province->id,
                'location_id'       => $location->id,
                'yalago_id'         => $h['EstablishmentId'],
                'name'              => $h['Title'] ?? null,
                'rating'            => $h['Rating'] ?? null,
                'address'           => $h['Address'] ?? null,
                'postal_code'       => $h['PostalCode'] ?? null,
                'phone'             => $h['PhoneNumber'] ?? null,
                'email'             => $h['Email'] ?? null,
                'longitude'         => $h['Longitude'] ?? null,
                'latitude'          => $h['Latitude'] ?? null,
                'geo_code_accuracy' => $h['GeocodeAccuracy'] ?? null,
                'description'       => $h['Description']['en'] ?? null,
                'summary'           => $h['Summary']['en'] ?? null,
                'images'            => json_encode($h['Images'] ?? []),
                'status'            => 'active',
            ];

            $hotel = Hotel::updateOrCreate(
                ['yalago_id' => $h['EstablishmentId']],
                $hotelData
            );

            // sync hotel rooms if available
            if (!empty($h['RoomTypes'])) {
                foreach ($h['RoomTypes'] as $r) {
                    Room::updateOrCreate(
                        [
                            'hotel_id' => $hotel->id,
                            'name'     => $r['Title']['en'] ?? null
                        ],
                        [
                            'hotel_id'     => $hotel->id,
                            'name'         => $r['Title']['en'] ?? null,
                            'description'  => $r['Description']['en'] ?? null,
                            'image'        => $r['ImageUrl'] ?? null,
                            'status'       => 'active',
                        ]
                    );
                }
            }

            $newCount++;
        }

        return redirect()->route('admin.hotels.index')
            ->with('notify_success', "{$newCount} Hotels synced");
    }

    public function syncDiff()
    {
        // 1. Use a dynamic recent date to keep payload small (e.g., last 24 hours)
        $date = gmdate('Y-m-d\TH:i:s\Z', strtotime('-1 day'));

        $payload = [
            "UpdatesAfter" => $date,
            "Languages"    => ["en"],
        ];

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Connection' => 'keep-alive',
            'Accept' => 'application/json',
            'Accept-Encoding' => 'application/gzip',
        ])->post('https://api.yalago.com/hotels/Inventory/GetEstablishmentDiff', $payload);

        if ($response->failed()) {
            return redirect()->back()
                ->with('notify_error', 'Failed to fetch hotel updates from Yalago.');
        }

        $responseData = $response->json();

        // 2. Mark deleted hotels as inactive
        if (!empty($responseData['Deleted'])) {
            foreach ($responseData['Deleted'] as $establishmentId) {
                $hotel = Hotel::where('yalago_id', $establishmentId)->first();
                if ($hotel) {
                    $hotel->update(['status' => 'inactive']);
                }
            }
        }

        // 3. Insert/update changed or new hotels
        $hotels = $responseData['Establishments'] ?? [];
        $newCount = 0;

        foreach ($hotels as $h) {
            // Find location, province, country from your DB
            $location = Location::where('yalago_id', $h['LocationId'])->first();
            if (!$location) continue; // skip if location not found
            $province = $location->province;
            $country  = $province->country;

            $hotelData = [
                'country_id'        => $country->id,
                'province_id'       => $province->id,
                'location_id'       => $location->id,
                'yalago_id'         => $h['EstablishmentId'],
                'name'              => $h['Title'] ?? null,
                'rating'            => $h['Rating'] ?? null,
                'address'           => $h['Address'] ?? null,
                'postal_code'       => $h['PostalCode'] ?? null,
                'phone'             => $h['PhoneNumber'] ?? null,
                'email'             => $h['Email'] ?? null,
                'longitude'         => $h['Longitude'] ?? null,
                'latitude'          => $h['Latitude'] ?? null,
                'geo_code_accuracy' => $h['GeocodeAccuracy'] ?? null,
                'description'       => $h['Description']['en'] ?? null,
                'summary'           => $h['Summary']['en'] ?? null,
                'images'            => json_encode($h['Images'] ?? []),
                'status'            => 'active',
            ];

            $hotel = Hotel::updateOrCreate(
                ['yalago_id' => $h['EstablishmentId']],
                $hotelData
            );

            // sync hotel rooms
            if (!empty($h['RoomTypes'])) {
                foreach ($h['RoomTypes'] as $r) {
                    Room::updateOrCreate(
                        [
                            'hotel_id' => $hotel->id,
                            'name'     => $r['Title']['en'] ?? null
                        ],
                        [
                            'hotel_id'     => $hotel->id,
                            'name'         => $r['Title']['en'] ?? null,
                            'description'  => $r['Description']['en'] ?? null,
                            'image'        => $r['ImageUrl'] ?? null,
                            'status'       => 'active',
                        ]
                    );
                }
            }

            $newCount++;
        }

        return redirect()->route('admin.hotels.index')
            ->with('notify_success', "{$newCount} Hotels updated/added from diff");
    }
}

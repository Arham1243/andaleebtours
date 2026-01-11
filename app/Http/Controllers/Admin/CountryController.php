<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public $apiKey = '93082895-c45f-489f-ae10-bed9eaae161e';
    public $url = 'https://api.yalago.com/hotels/Inventory/GetCountries';

    public function index()
    {
        $title = 'Manage Countries';
        $countries = Country::latest()->get();
        return view('admin.hotels.countries.list', compact('countries', 'title'));
    }

    public function create()
    {
        $title = 'Add New Country';
        return view('admin.hotels.countries.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:255|unique:countries,name',
            'yalago_id' => 'required|int',
            'status' => 'required|in:active,inactive',
        ]);

        Country::create([
            'name' => $request->name,
            'iso_code' => $request->iso_code,
            'yalago_id' => $request->yalago_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.countries.index')->with('notify_success', 'Country created successfully!');
    }

    public function edit(Country $country)
    {
        $title = 'Edit Country - ' . $country->name;
        return view('admin.hotels.countries.edit', compact('country', 'title'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'iso_code' => 'required|string|max:255|unique:countries,name',
            'yalago_id' => 'required|int',
            'status' => 'required|in:active,inactive',
        ]);

        $country->update([
            'name' => $request->name,
            'iso_code' => $request->iso_code,
            'yalago_id' => $request->yalago_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.countries.index')->with('notify_success', 'Country updated successfully!');
    }

    public function sync()
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Connection: keep-alive',
            'Accept' => 'application/json',
        ])->post($this->url, []);
        if ($response->failed()) {
            return redirect()->back()->with('notify_error', 'Failed to fetch countries from Yalago.');
        }
        $countries = $response->json('Countries', []);
        $newCount = 0;

        foreach ($countries as $country) {
                $existing = Country::where('yalago_id', $country['CountryId'])
                       ->orWhere('iso_code', $country['CountryCode'])
                       ->first();

            if ($existing) {
                $existing->update([
                    'iso_code' => $country['CountryCode'],
                    'name' => $country['Title'],
                    'status' => 'active',
                ]);
            } else {
                Country::create([
                    'yalago_id' => $country['CountryId'],
                    'iso_code' => $country['CountryCode'],
                    'name' => $country['Title'],
                    'status' => 'active',
                ]);
                $newCount++;
            }
        }

        return redirect()->route('admin.countries.index')
            ->with('notify_success', "{$newCount} Countries synced");
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
        $title = 'Manage Flights';
        $flights = Flight::latest()->get();
        return view('admin.flights.list', compact('flights', 'title'));
    }

    public function create()
    {
        $title = 'Add New Flight';
        return view('admin.flights.add', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_name' => 'required|string|max:255',
            'origin_code' => 'required|string|max:10',
            'destination_code' => 'required|string|max:10',
            'badge' => 'nullable|string|max:255',
            'departure_date' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'class' => 'required|string|max:255',
            'is_featured' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'flights');
        }

        Flight::create([
            'destination_name' => $request->destination_name,
            'origin_code' => $request->origin_code,
            'destination_code' => $request->destination_code,
            'badge' => $request->badge,
            'departure_date' => $request->departure_date,
            'duration' => $request->duration,
            'price' => $request->price,
            'class' => $request->class,
            'image' => $imagePath,
            'status' => $request->status,
            'is_featured' => isset($request->is_featured) ? $request->is_featured : 0,
        ]);

        return redirect()->route('admin.flights.index')->with('notify_success', 'Flight created successfully!');
    }

    public function edit(Flight $flight)
    {
        $title = 'Edit Flight - ' . $flight->destination_name;
        return view('admin.flights.edit', compact('flight', 'title'));
    }

    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'destination_name' => 'required|string|max:255',
            'origin_code' => 'required|string|max:10',
            'destination_code' => 'required|string|max:10',
            'badge' => 'nullable|string|max:255',
            'departure_date' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'class' => 'required|string|max:255',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imagePath = $flight->image;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), 'flights', $flight->image);
        }

        $flight->update([
            'destination_name' => $request->destination_name,
            'origin_code' => $request->origin_code,
            'destination_code' => $request->destination_code,
            'badge' => $request->badge,
            'departure_date' => $request->departure_date,
            'duration' => $request->duration,
            'price' => $request->price,
            'class' => $request->class,
            'image' => $imagePath,
            'status' => $request->status,
            'is_featured' => isset($request->is_featured) ? $request->is_featured : 0,
        ]);

        return redirect()->route('admin.flights.index')->with('notify_success', 'Flight updated successfully!');
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return redirect()->route('admin.flights.index')->with('notify_success', 'Flight deleted successfully!');
    }

    public function changeStatus(Flight $flight)
    {
        $newStatus = $flight->status === 'active' ? 'inactive' : 'active';
        $flight->update(['status' => $newStatus]);
        return redirect()->route('admin.flights.index')->with('notify_success', 'Flight status changed successfully!');
    }
}

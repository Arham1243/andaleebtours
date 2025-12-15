<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class FlightController extends Controller
{
    public function index()
    {
        return view('frontend.flights.index');
    }
}

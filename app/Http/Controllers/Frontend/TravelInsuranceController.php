<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Country;

class TravelInsuranceController extends Controller
{
    public function index()
    {
        return view('frontend.travel-insurance.index');
    }
    public function details()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return view('frontend.travel-insurance.details', compact('countries'));
    }
}

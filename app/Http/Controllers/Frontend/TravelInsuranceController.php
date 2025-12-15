<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class TravelInsuranceController extends Controller
{
    public function index()
    {
        return view('frontend.travel-insurance.index');
    }
    public function details()
    {
        return view('frontend.travel-insurance.details');
    }
}

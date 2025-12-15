<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HotelController extends Controller
{
    public function index()
    {
        return view('frontend.hotels.index');
    }
}

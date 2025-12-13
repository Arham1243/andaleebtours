<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('frontend.home');
    }
    public function privacy_policy()
    {
        return view('frontend.privacy-policy');
    }
    public function terms_and_conditions()
    {
        return view('frontend.terms-conditions');
    }
    public function company_profile()
    {
        return view('frontend.company-profile');
    }
    public function about_us()
    {
        return view('frontend.about-us');
    }
}

<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function signup()
    {
        return view('frontend.auth.signup');
    }

}

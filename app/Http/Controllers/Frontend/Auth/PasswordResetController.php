<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    public function forgotPassword()
    {
        return view('frontend.auth.forgot-password.index');
    }

    public function resetPassword()
    {
        return view('frontend.auth.forgot-password.reset');
    }
}

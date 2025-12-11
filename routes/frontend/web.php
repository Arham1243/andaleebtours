<?php

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/signup', [AuthController::class, 'signup'])->name('auth.signup');
    Route::get('/password/forgot', [PasswordResetController::class, 'forgotPassword'])->name('auth.password.forgot');
    Route::get('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('auth.password.reset');
});

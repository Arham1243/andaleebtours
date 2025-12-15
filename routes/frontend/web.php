<?php

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\PasswordResetController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\Frontend\TravelInsuranceController;
use App\Http\Controllers\Frontend\HotelController;
use App\Http\Controllers\Frontend\FlightController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/signup', [AuthController::class, 'signup'])->name('auth.signup');
    Route::get('/my-booking', [AuthController::class, 'myBooking'])->name('auth.my-booking');
    Route::get('/password/forgot', [PasswordResetController::class, 'forgotPassword'])->name('auth.password.forgot');
    Route::get('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('auth.password.reset');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('/uae-services', [TourController::class, 'uae_services'])->name('uae-services');
    Route::get('/holiday-packages', [TourController::class, 'holiday_packages'])->name('holiday-packages');
    Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');
    Route::get('/company-profile', [IndexController::class, 'company_profile'])->name('company-profile');
    Route::get('/about-us', [IndexController::class, 'about_us'])->name('about-us');
    Route::get('/contact-us', [IndexController::class, 'contact_us'])->name('contact-us');

    Route::prefix('travel-insurance')->name('travel-insurance.')->group(function () {
        Route::get('/', [TravelInsuranceController::class, 'index'])->name('index');
        Route::get('/details', [TravelInsuranceController::class, 'details'])->name('details');
    });

    Route::prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
    });

    Route::prefix('flights')->name('flights.')->group(function () {
        Route::get('/', [FlightController::class, 'index'])->name('index');
    });
});

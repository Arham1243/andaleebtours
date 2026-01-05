<?php

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\TourController;
use App\Http\Controllers\Frontend\TourCategoryController;
use App\Http\Controllers\Frontend\TravelInsuranceController;
use App\Http\Controllers\Frontend\HotelController;
use App\Http\Controllers\Frontend\FlightController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('store');
    });
    
    // Test routes for insurance email templates
    Route::get('/test-insurance-success-user/{id}', [IndexController::class, 'testInsuranceSuccessUser']);
    Route::get('/test-insurance-success-admin/{id}', [IndexController::class, 'testInsuranceSuccessAdmin']);
    Route::get('/test-insurance-failed-user/{id}', [IndexController::class, 'testInsuranceFailedUser']);
    Route::get('/test-insurance-failed-admin/{id}', [IndexController::class, 'testInsuranceFailedAdmin']);

    Route::post('/subscribe-newsletter', [IndexController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

    Route::get('/uae-services', [TourController::class, 'uae_services'])->name('uae-services');
    Route::get('/privacy-policy', [IndexController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/terms-and-conditions', [IndexController::class, 'terms_and_conditions'])->name('terms-and-conditions');
    Route::get('/company-profile', [IndexController::class, 'company_profile'])->name('company-profile');
    Route::get('/about-us', [IndexController::class, 'about_us'])->name('about-us');
    Route::get('/contact-us', [IndexController::class, 'contact_us'])->name('contact-us');
    Route::post('/contact-us', [IndexController::class, 'submitContact'])->name('contact.submit');

    Route::prefix('travel-insurance')->name('travel-insurance.')->group(function () {
        Route::get('/', [TravelInsuranceController::class, 'index'])->name('index');
        Route::get('/details', [TravelInsuranceController::class, 'details'])->name('details');
        Route::post('/payment/process', [TravelInsuranceController::class, 'processPayment'])->name('payment.process');
        Route::get('/payment/success/{insurance}', [TravelInsuranceController::class, 'paymentSuccess'])->name('payment.success');
        Route::get('/payment/failed', [TravelInsuranceController::class, 'paymentFailed'])->name('payment.failed');
    });

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{slug}', [CartController::class, 'add'])->name('add');
        Route::patch('/update/{slug}', [CartController::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    });

    Route::prefix('tour')->name('tour.')->group(function () {
        Route::get('/details/{slug}', [TourController::class, 'details'])->name('details');
        Route::post('/save-review/{slug}', [TourController::class, 'saveReview'])->name('save-review');
    });
    Route::prefix('tour-category')->name('tour-category.')->group(function () {
        Route::get('/{slug}', [TourCategoryController::class, 'details'])->name('details');
    });

    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::get('/category/{slug}', [PackageController::class, 'category'])->name('category');
        Route::get('/{slug}', [PackageController::class, 'details'])->name('details');
        Route::post('/inquiry', [PackageController::class, 'submitInquiry'])->name('inquiry.submit');
    });

    Route::prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/search', [HotelController::class, 'search'])->name('search');
        Route::get('/details', [HotelController::class, 'details'])->name('details');
        Route::get('/extras', [HotelController::class, 'extras'])->name('extras');
        Route::get('/checkout', [HotelController::class, 'checkout'])->name('checkout');
    });
    
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/success', [CheckoutController::class, 'paymentSuccess'])->name('success');
        Route::get('/failed', [CheckoutController::class, 'paymentFailed'])->name('failed');
    });

    Route::prefix('flights')->name('flights.')->group(function () {
        Route::get('/', [FlightController::class, 'index'])->name('index');
    });

    Route::post('/load/tour/blocks', [TourController::class, 'loadTourBlocks'])->name('load.tour.blocks');


    Route::get('/auth/redirect/{social}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.redirect');
    Route::get('/auth/callback/{social}', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.callback');
});

<?php

use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\BulkActionController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PackageCategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\TourCategoryController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageInquiryController;
use App\Http\Controllers\Admin\DBConsoleController;
use App\Http\Controllers\Admin\EnvEditorController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\TourReviewController;
use App\Http\Controllers\Admin\TerminalController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\HotelBookingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TravelInsuranceController;
use Illuminate\Support\Facades\Route;

Route::get('/admins', function () {
    return redirect()->route('admin.login');
})->name('admin.admin');

Route::middleware('guest')->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/auth', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/perform-login', [AdminLoginController::class, 'performLogin'])->name('admin.performLogin')->middleware('throttle:5,1');
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::get('/terminal', [TerminalController::class, 'index']);
    Route::post('/terminal/run', [TerminalController::class, 'run']);

    Route::get('/db-console', [DBConsoleController::class, 'index']);
    Route::post('/db-console', [DBConsoleController::class, 'run'])->name('db.console.run');

    Route::get('/env-editor', [EnvEditorController::class, 'index'])->name('env');
    Route::post('/env-editor', [EnvEditorController::class, 'save'])->name('env.save');

    Route::get('logs', [LogController::class, 'read']);
    Route::get('logs/delete', [LogController::class, 'delete']);

    Route::post('bulk-actions/{resource}', [BulkActionController::class, 'handle'])->name('bulk-actions');

    Route::resource('users', UserController::class);
    Route::get('users/change-status/{user}', [UserController::class, 'changeStatus'])->name('users.change-status');

    Route::resource('newsletters', NewsletterController::class);
    Route::get('newsletters/change-status/{newsletter}', [NewsletterController::class, 'changeStatus'])->name('newsletters.change-status');

    Route::resource('inquiries', InquiryController::class);

    Route::resource('banners', BannerController::class);
    Route::get('banners/change-status/{banner}', [BannerController::class, 'changeStatus'])->name('banners.change-status');

    Route::get('tours/sync', [TourController::class, 'sync'])->name('tours.sync');
    Route::post('tours/sync', [TourController::class, 'handleSync'])->name('tours.sync.update');
    Route::get('tours/change-status/{tour}', [TourController::class, 'changeStatus'])->name('tours.change-status');
    Route::resource('tours', TourController::class);

    Route::resource('tour-categories', TourCategoryController::class);
    Route::get('tour-categories/change-status/{tourCategory}', [TourCategoryController::class, 'changeStatus'])->name('tour-categories.change-status');

    Route::resource('flights', FlightController::class);
    Route::get('flights/change-status/{flight}', [FlightController::class, 'changeStatus'])->name('flights.change-status');

    Route::resource('package-categories', PackageCategoryController::class);
    Route::get('package-categories/change-status/{packageCategory}', [PackageCategoryController::class, 'changeStatus'])->name('package-categories.change-status');

    Route::resource('packages', PackageController::class);
    Route::get('packages/change-status/{package}', [PackageController::class, 'changeStatus'])->name('packages.change-status');

    Route::resource('package-inquiries', PackageInquiryController::class)->only(['index', 'show', 'destroy']);

    Route::resource('tour-reviews', TourReviewController::class);

    Route::get('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);

    Route::get(
        'hotel-bookings/{hotel}/cancel',
        [HotelBookingController::class, 'cancel']
    )->name('hotel-bookings.cancel');

    Route::resource(
        'hotel-bookings',
        HotelBookingController::class
    )->only(['index', 'show', 'update']);
    Route::post(
        '/hotels/cancellation-charges',
        [HotelBookingController::class, 'getCancellationCharges']
    )->name('hotels.cancellation.charges');
    Route::get(
        '/hotels/{id}/cancel',
        [HotelBookingController::class, 'cancel']
    )->name('hotels.cancel');

    Route::resource('travel-insurances', TravelInsuranceController::class)->only(['index', 'show', 'update']);

    Route::resource('coupons', CouponController::class);
    Route::get('coupons/change-status/{coupon}', [CouponController::class, 'changeStatus'])->name('coupons.change-status');

    Route::get('countries/sync', [CountryController::class, 'sync'])->name('countries.sync');
    Route::resource('countries', CountryController::class);

    Route::get('provinces/{country}/sync', [ProvinceController::class, 'sync'])->name('provinces.sync');
    Route::resource('provinces', ProvinceController::class);

    Route::get('locations/{country}/{province}/sync', [LocationController::class, 'sync'])->name('locations.sync');
    Route::resource('locations', LocationController::class);

    Route::get('hotels/{country}/{province}/{location}/sync', [HotelController::class, 'sync'])->name('hotels.sync');
    Route::get('hotels/sync', [HotelController::class, 'syncDiff'])->name('hotels.sync.diff');
    Route::resource('hotels', HotelController::class);

    Route::get('logo-management', [ConfigController::class, 'logoManagement'])->name('settings.logo');
    Route::post('logo-management', [ConfigController::class, 'saveLogo'])->name('settings.logo');
    Route::get('details', [ConfigController::class, 'details'])->name('settings.details');
    Route::post('details', [ConfigController::class, 'saveDetails'])->name('settings.details');
});

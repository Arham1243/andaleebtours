<?php

use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\PasswordResetController;
use App\Http\Controllers\User\UserDashController;
use App\Http\Controllers\User\ProfileSettingsController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->middleware('user_guest')->group(function () {
    Route::get('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('signup', [AuthController::class, 'performSignup'])->name('signup.perform');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'performLogin'])->name('login.perform');
    Route::get('/my-booking', [AuthController::class, 'myBooking'])->name('my-booking');
});

Route::get('password/reset', [PasswordResetController::class, 'index'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/notify', [PasswordResetController::class, 'notify'])->name('password.notify');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');
Route::post('/booking/send', [AuthController::class, 'sendBookingByEmail'])
    ->name('booking.send');

Route::middleware(['auth', 'check_user_status'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/destroy/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/pay-again/{id}', [OrderController::class, 'payAgain'])->name('orders.pay-again');

    Route::get('profile/change/password', [ProfileSettingsController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('profile/change/password/update', [ProfileSettingsController::class, 'updatePassword'])->name('profile.updatePassword');
});

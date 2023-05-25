<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\HomestayController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Homestay
Route::get('homestays', [HomestayController::class, 'index'])->name('homestays');
Route::get('homestays/{homestay}', [HomestayController::class, 'show'])->name('homestays.show');
Route::post('whislist/toggle', [HomestayController::class, 'toggle_wishlist'])->name('whislist.toggle');

// Event
Route::get('events', [EventController::class, 'index'])->name('events');
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('login', [AuthController::class, 'login'])->name('index');
Route::post('login', [AuthController::class, 'do_login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'do_register'])->name('do_register');
Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('forgot', [AuthController::class, 'do_forgot'])->name('do_forgot');
Route::get('password/reset/{token}', [AuthController::class, 'reset'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'do_reset'])->name('password.update');
Route::get('password/change', [AuthController::class, 'change'])->name('password.change');
Route::post('payments/midtrans-notification', [BookingController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    Route::post('review', [HomestayController::class, 'review'])->name('review');

    // Booking
    Route::post('booking/check', [BookingController::class, 'check'])->name('booking.check');
    Route::post('booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::put('booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::get('booking/{id}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');
    Route::get('booking/{id}/download', [BookingController::class, 'download'])->name('booking.download');
    Route::put('booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/update-password', [ProfileController::class, 'update_password'])->name('profile.update-password');
    Route::put('profile/update-profile', [ProfileController::class, 'update_profile'])->name('profile.update-profile');
    Route::post('profile/upload-profile', [ProfileController::class, 'upload_profile'])->name('profile.upload-profile');
    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');

    // Notifications
    Route::get('counter', [NotificationController::class, 'counter'])->name('counter_notif');
    Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
    Route::resource('notifications', NotificationController::class);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\FacilityController;
use App\Http\Controllers\Backend\HomestayController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\RequestController;


Route::name('backend.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Users
    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::post('delete-selected-users', [UserController::class, 'delete_selected'])->name('users.delete_selected')->middleware('role:admin');

    //Facilites
    Route::resource('facilities', FacilityController::class)->middleware('role:admin');
    Route::post('delete-selected-facilities', [FacilityController::class, 'delete_selected'])->name('facilities.delete_selected')->middleware('role:admin');

    //Homestays
    Route::get('homestays/{homestay}/getImages', [HomestayController::class, 'getImages'])->name('homestays.getImages');
    Route::post('homestays/storeImage', [HomestayController::class, 'storeImage'])->name('homestays.storeImage');
    Route::delete('homestays/deleteImage', [HomestayController::class, 'deleteImage'])->name('homestays.deleteImage');
    Route::resource('homestays', HomestayController::class);
    Route::post('delete-selected-homestays', [HomestayController::class, 'delete_selected'])->name('homestays.delete_selected');

    //Request Homestays
    Route::prefix('request')->middleware('role:admin')->name('requests.')->group(function () {
        Route::get('', [RequestController::class, 'index'])->name('index');
        Route::get('{request}', [RequestController::class, 'show'])->name('show');
        Route::put('{request}/approve', [RequestController::class, 'approve'])->name('approve');
        Route::put('{request}/reject', [RequestController::class, 'reject'])->name('reject');
    });

    //Events
    Route::get('events/{event}/getImages', [EventController::class, 'getImages'])->name('events.getImages')->middleware('role:admin');
    Route::post('events/storeImage', [EventController::class, 'storeImage'])->name('events.storeImage')->middleware('role:admin');
    Route::delete('events/deleteImage', [EventController::class, 'deleteImage'])->name('events.deleteImage')->middleware('role:admin');
    Route::resource('events', EventController::class)->middleware('role:admin');
    Route::post('delete-selected-events', [EventController::class, 'delete_selected'])->name('events.delete_selected')->middleware('role:admin');

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('', [BookingController::class, 'index'])->name('index');
        Route::get('pdf', [BookingController::class, 'pdf'])->name('pdf');
        Route::get('{booking}', [BookingController::class, 'show'])->name('show');
        Route::put('{booking}/approve', [BookingController::class, 'approve'])->name('approve');
        Route::put('{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        Route::put('{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        Route::put('{booking}/complete', [BookingController::class, 'complete'])->name('complete');
    });

    // Settings
    Route::prefix('settings')->middleware('role:admin')->name('settings.')->group(function () {
        Route::get('', [SettingController::class, 'index'])->name('index');
        Route::put('update_site', [SettingController::class, 'update_site'])->name('update_site');
        Route::put('update_user', [SettingController::class, 'update_user'])->name('update_user');
        Route::put('update_seo', [SettingController::class, 'update_seo'])->name('update_seo');
    });

    // Notifications
    Route::get('counter', [NotificationController::class, 'counter'])->name('counter_notif');
    Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
    Route::resource('notifications', NotificationController::class);

    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\FacilityController;
use App\Http\Controllers\Backend\HomestayController;
use App\Http\Controllers\Backend\DashboardController;


Route::name('backend.')->middleware(['auth', 'role:admin|owner'])->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Users
    Route::resource('users', UserController::class);

    //Facilites
    Route::resource('facilities', FacilityController::class);

    //Homestays
    Route::get('homestays/{homestay}/getImages', [HomestayController::class, 'getImages'])->name('homestays.getImages');
    Route::post('homestays/storeImage', [HomestayController::class, 'storeImage'])->name('homestays.storeImage');
    Route::delete('homestays/deleteImage', [HomestayController::class, 'deleteImage'])->name('homestays.deleteImage');
    Route::resource('homestays', HomestayController::class);

    //Events
    Route::get('events/{event}/getImages', [EventController::class, 'getImages'])->name('events.getImages');
    Route::post('events/storeImage', [EventController::class, 'storeImage'])->name('events.storeImage');
    Route::delete('events/deleteImage', [EventController::class, 'deleteImage'])->name('events.deleteImage');
    Route::resource('events', EventController::class);

    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

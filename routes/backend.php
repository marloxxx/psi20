<?php

use Illuminate\Support\Facades\Route;

Route::name('backend.')->middleware(['auth', 'verified', 'role:admin|owner'])->group(function () {
    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

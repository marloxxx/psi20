<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

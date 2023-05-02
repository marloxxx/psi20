<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\HomestayController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('homestays', [HomestayController::class, 'index'])->name('homestays');
Route::get('homestays/{homestay}', [HomestayController::class, 'show'])->name('homestays.show');
Route::get('events', [EventController::class, 'events'])->name('events');
Route::get('events/{event}', [EventController::class, 'event'])->name('events.show');

// Route::get('/email/verify', function () {
//     if (Auth::user()->email_verified_at == null) {
//         return view('pages.auth.verify');
//     } else {
//         return redirect()->route('dashboard');
//     }
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return view('pages.auth.welcome');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return response()->json([
//         'status' => 'success',
//         'message' => 'Verification email sent.',
//     ]);
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('login', [AuthController::class, 'login'])->name('index');
Route::post('login', [AuthController::class, 'do_login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'do_register'])->name('do_register');
Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('forgot', [AuthController::class, 'do_forgot'])->name('do_forgot');
Route::get('password/reset/{token}', [AuthController::class, 'reset'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'do_reset'])->name('password.update');
Route::get('password/change', [AuthController::class, 'change'])->name('password.change');

Route::middleware(['auth', 'role:customer|owner'])->group(function () {
    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

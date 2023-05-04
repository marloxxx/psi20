<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\EventController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\HomestayController;
use App\Http\Controllers\Frontend\ProfileController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('homestays', [HomestayController::class, 'index'])->name('homestays');
Route::get('homestays/{homestay}', [HomestayController::class, 'show'])->name('homestays.show');
Route::post('whislist/toggle', [HomestayController::class, 'toggle_wishlist'])->name('whislist.toggle');
Route::get('events', [EventController::class, 'index'])->name('events');
Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

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
Route::post('payments/midtrans-notification', [BookingController::class, 'callback']);

Route::middleware(['auth'])->group(function () {
    Route::post('review', [HomestayController::class, 'review'])->name('review');

    // Booking
    Route::post('booking/check', [BookingController::class, 'check'])->name('booking.check');
    Route::post('booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('booking/{id}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');
    Route::put('booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/update-password', [ProfileController::class, 'update_password'])->name('profile.update-password');
    Route::put('profile/update-profile', [ProfileController::class, 'update_profile'])->name('profile.update-profile');
    Route::get('logout', [AuthController::class, 'do_logout'])->name('logout');
});

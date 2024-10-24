<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/', [UserController::class, 'index'])->middleware('user');

Route::get('/register', [UserController::class, 'showRegistrationForm']);
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [UserController::class, 'login'])->name('login');



Route::patch('/admin/order/update/{id}', [AdminController::class, 'updateStatus'])->name('admin.order.update');

Route::get('/mybookings', [UserController::class, 'myBooking'])->name('user.bookings')->middleware('user');


Route::post('/logout', [UserController::class, 'destroy'])->name('user.logout');

Route::get('/product/checkout/{id}', [CheckoutController::class, 'index'])->name('product.details')->middleware('user');


Route::post('/product/order', [CheckoutController::class, 'order'])->name('product.order')->middleware('user');

// email verify routes

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/otp/verify', [UserController::class, 'verifyOtp'])->name('otp.verify');






Route::get('admin/login', [AdminController::class, 'index'])->name('admin_login_form');
Route::post('login/owner', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

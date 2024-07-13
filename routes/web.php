<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', [UserController::class, 'index'])->middleware('user');

Route::get('/register', [UserController::class, 'showRegistrationForm']);
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [UserController::class, 'login'])->name('login');


Route::post('/logout', [UserController::class, 'destroy'])->name('user.logout');

Route::get('/product/checkout/{id}', [CheckoutController::class, 'index'])->name('product.details')->middleware('user');


Route::post('/product/order', [CheckoutController::class, 'order'])->name('product.order')->middleware('user');


// Route::middleware(['admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
//     // Other admin routes
// });



Route::get('admin/login', [AdminController::class, 'index'])->name('admin_login_form');
Route::post('login/owner', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

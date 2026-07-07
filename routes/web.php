<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\ResetPasswordController; 
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;


Route::middleware('guest')->group(function () {

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
});

Route::middleware('guest')->name('user.')->group(function () {
    
    // Identity Registry (Registration)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // One-Time Passcode Lifecycle (OTP)
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/verify-otp/resend', [AuthController::class, 'resendOtp'])->name('verify.resend');

    // Secure Gate Entry (Public Login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Security Credential Recovery (Forgot / Reset Password)
    Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
});


Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/about', [AboutController::class, 'index'])->name('user.about');
Route::get('/shop', [ShopController::class, 'index'])->name('user.shop');
Route::get('/contact', [ContactController::class, 'index'])->name('user.contact');
Route::post('/contact', [ContactController::class, 'send'])->name('user.contact.send');
Route::get('/watches', [ShopController::class, 'watches'])->name('user.watches');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('user.product.detail');

// Cart Routes
Route::prefix('cart')->name('user.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('user.checkout');
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('user.checkout.place');


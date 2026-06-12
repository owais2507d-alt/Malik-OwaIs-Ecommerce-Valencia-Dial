<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController; 
use App\Http\Controllers\Admin\WatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes & Core Showroom (Sectored with Authentication)
|--------------------------------------------------------------------------
*/
// Error image_a10062.png resolved: Changed .name('home') to .name('shop.index')
// Middleware auth applied so guest users are forced to login first
Route::get('/', [HomeController::class, 'index'])->name('shop.index')->middleware('auth');
Route::get('/watch/{id}', [HomeController::class, 'show'])->name('shop.show')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Guest Authentication Gateway (Only for Logged-Out Users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    
    // Identity Registry (Registration)
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // One-Time Passcode Lifecycle (OTP)
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/verify-otp/resend', [AuthController::class, 'resendOtp'])->name('verify.resend');

    // Secure Gate Entry (Login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Security Credential Recovery (Forgot / Reset Password)
    Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| Protected Operational Subsystems (Requires Valid Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Revoke Session (Logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Elite Secure Admin Console (Protected via Role Shield)
    |--------------------------------------------------------------------------
    */
    Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function() {
        
        // Control Tower Central Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Master Catalogue Operations (Watch CRUD Matrix)
        Route::get('/watches', [WatchController::class, 'index'])->name('watches.index');
        Route::get('/watches/create', [WatchController::class, 'create'])->name('watches.create');
        Route::post('/watches', [WatchController::class, 'store'])->name('watches.store');
        Route::get('/watches/{id}/edit', [WatchController::class, 'edit'])->name('watches.edit');
        Route::put('/watches/{id}', [WatchController::class, 'update'])->name('watches.update');
        Route::delete('/watches/{id}', [WatchController::class, 'destroy'])->name('watches.destroy');
    });
});
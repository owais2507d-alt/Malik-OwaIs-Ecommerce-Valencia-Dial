<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


// Home Route (Frontend landing page)
Route::get('/', function () {
    return view('frontend.home'); // Aapki frontend home blade file ka path
})->name('home');


// guest route 
Route::middleware('guest')->group(function () {
    
    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // OTP Verification Routes
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    // OTP Resend Route
    Route::post('/verify-otp/resend', [AuthController::class, 'resendOtp'])->name('verify.resend');

    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


///auth routes
Route::middleware('auth')->group(function () {
    
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return "Welcome to Valencia Dial Admin Dashboard!";
    })->name('admin.dashboard');
});
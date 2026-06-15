<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController; 
use App\Http\Controllers\Admin\WatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\CartController;

/*
|--------------------------------------------------------------------------
| Public Routes & Core Showroom (Sectored - Accessible to Everyone)
|--------------------------------------------------------------------------
| Ab koi bhi user bina login kiye aapka home page aur single product details
| dekh sakta hai. No more annoying redirection!
*/
Route::get('/', [HomeController::class, 'index'])->name('shop.index');
Route::get('/watch/{id}', [HomeController::class, 'show'])->name('shop.show');


/*
|--------------------------------------------------------------------------
| Protected Client Vault (Authenticated Public Users Only)
|--------------------------------------------------------------------------
| Is block ke andar sirf wahi routes aayenge jinke liye login hona laazmi hai.
*/
Route::middleware('auth')->group(function () {
    
    // Revoke Session (Logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Note: Future mein Cart aur Checkout ke routes bhi aap is block ke andar daalna.
});


/*
|--------------------------------------------------------------------------
| Guest Authentication Gateway (Only for Logged-Out Public Users)
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

    // Secure Gate Entry (Public Login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Security Credential Recovery (Forgot / Reset Password)
    Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');

    /*
    |--------------------------------------------------------------------------
    | Dedicated Private Admin Authentication Gateway
    |--------------------------------------------------------------------------
    | Placed strictly under 'guest' middleware so logged-out admins can access.
    */

});


    Route::get('admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');


/*
|--------------------------------------------------------------------------
| Elite Secure Admin Console (Protected via Auth & Role Shield)
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function() {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('watches', WatchController::class);
});

////  Bespoke Cart Lifecycle Routes


Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/add',[CartController::class,'add'])->name('cart.add');
Route::post('/cart/remove/{$id}',[CartController::class,'remove'])->name('cart.remove');
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\WatchController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Frontend Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('frontend.home'); 
})->name('home');

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes (Only for Logged-Out Users)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    
    // Registration Feature
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // OTP Verification Process
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/verify-otp/resend', [AuthController::class, 'resendOtp'])->name('verify.resend');

    // Authentication Session Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // 1. Forgot Password (Request Link Form)
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    // 2. Forgot Password (Process & Send Link)
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    // 3. Reset Password (Render New Password Form)
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    // 4. Reset Password (Update Password in Database)
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Session Routes (Requires Valid Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Terminate User Session
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Secure Admin Panel Routes (Protected via AdminMiddleware)
    |--------------------------------------------------------------------------
    */
    Route::middleware([AdminMiddleware::class])->group(function() {
        
        // Admin Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Watch Inventory Framework Controls 
        Route::get('/admin/watches', [WatchController::class, 'index'])->name('admin.watches.index');
        Route::get('/admin/watches/create', [WatchController::class, 'create'])->name('admin.watches.create');
        Route::post('/admin/watches', [WatchController::class, 'store'])->name('admin.watches.store');
    });
    
    Route::get('/admin/watches/{id}/edit', [WatchController::class, 'edit'])->name('admin.watches.edit');
Route::put('/admin/watches/{id}', [WatchController::class, 'update'])->name('admin.watches.update');
Route::delete('/admin/watches/{id}', [WatchController::class, 'destroy'])->name('admin.watches.destroy');

});
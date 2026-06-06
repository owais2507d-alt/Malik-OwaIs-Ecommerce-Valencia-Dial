<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeOtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    } 

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $otp = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'otp_code' => $otp,
            'is_verified' => 0
        ]); 

        Mail::to($user->email)->send(new WelcomeOtpMail($user, $otp));
        session(['verify_email' => $user->email]);

        return redirect()->route('verify.otp')->with('success', 'OTP sent to your email.');
    }

    public function showVerifyOtp() {
        if (!session()->has('verify_email')) {
            return redirect()->route('register');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request) {
    $request->validate([
        'otp' => 'required'
    ]);

    $email = session('verify_email');
    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('register')->with('error', 'User not found.');
    }

    if (Carbon::now()->diffInSeconds(Carbon::parse($user->updated_at)) > 120) {
        return back()->withErrors(['otp' => 'OTP expired. Please request a new one.']);
    }

    if ($user->otp_code && trim((string)$user->otp_code) === trim((string)$request->otp)) {
        $user->update([
            'is_verified' => 1,
            'otp_code' => null
        ]);

        session()->forget('verify_email');

        // 1. User ko automatically login karwein
        Auth::login($user);
        $request->session()->regenerate();

        // 2. Role ke mutabik dashboard par redirect karein
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home'); // Ya aapka customer dashboard route
    }

    return back()->withErrors(['otp' => 'Invalid OTP, please recheck.']);
}
    public function resendOtp(Request $request) {
        if (!session()->has('verify_email')) {
            return redirect()->route('register')->with('error', 'Register first.');
        }

        $email = session('verify_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $newOtp = rand(100000, 999999);
            $user->update(['otp_code' => $newOtp]);
            
            Mail::to($user->email)->send(new WelcomeOtpMail($user, $newOtp));
            return back()->with('success', 'New OTP sent. Valid for 2 minutes.');
        }

        return back()->with('error', 'User not found.');
    }

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if ($user && $user->is_verified == 0) {
            $newOtp = rand(100000, 999999);
            $user->update(['otp_code' => $newOtp]);
            Mail::to($user->email)->send(new WelcomeOtpMail($user, $newOtp));
            
            session(['verify_email' => $user->email]);
            return redirect()->route('verify.otp')->with('success', 'Account not verified. New OTP sent.');
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout successful');
    }
}
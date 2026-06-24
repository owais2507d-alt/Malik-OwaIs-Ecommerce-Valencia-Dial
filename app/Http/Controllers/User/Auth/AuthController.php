<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeOtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show Register Form
     */
    public function showRegister() 
    {
        return view('user.auth.register');
    } 

    /**
     * Handle User Registration
     */
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $otp = rand(100000, 999999);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp_code' => $otp,
            'is_verified' => 0
        ]); 

        session(['verify_email' => $user->email]);

        // 2. Send Mail with Error Catching
        try {
            Mail::to($user->email)->send(new WelcomeOtpMail($user, $otp));
        } catch (\Exception $e) {
            Log::error('Mail sending failed in register: ' . $e->getMessage());
            
            //
            return redirect()->route('user.verify.otp')->with('error', 'Account created, but Mail failed to send. Error: ' . $e->getMessage());
        }

        return redirect()->route('user.verify.otp')->with('success', 'Registration successful! Check your email for OTP.');
    }

    /**
     * Show OTP Verification Screen
     */
    public function showVerifyOtp() 
    {
        if (!session()->has('verify_email')) {
            return redirect()->route('register');
        }
        return view('user.auth.verify-otp');
    }

    /**
     * Verify OTP Code
     */
    public function verifyOtp(Request $request) 
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('verify_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('user.register')->with('error', 'User not found.');
        }

        // 1. Check if OTP is expired (2 Minutes / 120 Seconds code expiry)
        if (Carbon::now()->diffInSeconds(Carbon::parse($user->updated_at)) > 120) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new one.']);
        }

        // 2. Match OTP
        if ($user->otp_code && trim((string)$user->otp_code) === trim((string)$request->otp)) {
            $user->update([
                'is_verified' => 1,
                'otp_code' => null
            ]);

            session()->forget('verify_email');
            
            // Auto Login after successful verification
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.home'); 
        }

        return back()->withErrors(['otp' => 'Invalid OTP, please recheck.']);
    }

    /**
     * Resend Verification OTP
     */
    public function resendOtp(Request $request) 
    {
        if (!session()->has('verify_email')) {
            return redirect()->route('user.register')->with('error', 'Register first.');
        }

        $email = session('verify_email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $newOtp = rand(100000, 999999);
            
            // updated_at timestamp u
            $user->update(['otp_code' => $newOtp]);
            
            try {
                Mail::to($user->email)->send(new WelcomeOtpMail($user, $newOtp));
                return back()->with('success', 'New OTP sent. Valid for 2 minutes.');
            } catch (\Exception $e) {
                Log::error('Mail sending failed in resendOtp: ' . $e->getMessage());
                return back()->with('error', 'Failed to send new OTP email.');
            }
        }

        return back()->with('error', 'User not found.');
    }

    /**
     * Show Login Page
     */
    public function showLogin() 
    {
        return view('user.auth.login');
    }

    /**
     * Handle Login Attempt
     */
    public function login(Request $request) 
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        // Block unverified users and send new OTP
        if ($user && $user->is_verified == 0) {
            $newOtp = rand(100000, 999999);
            $user->update(['otp_code' => $newOtp]);
            
            try {
                Mail::to($user->email)->send(new WelcomeOtpMail($user, $newOtp));
            } catch (\Exception $e) {
                Log::error('Mail sending failed in login: ' . $e->getMessage());
            }
            
            session(['verify_email' => $user->email]);
            return redirect()->route('verify.otp')->with('success', 'Account not verified. New OTP sent.');
        }

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect("/");
        }

        return back()->withErrors(['email' => 'Invalid email or password'])->onlyInput('email');
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login')->with('success', 'Logout successful');
    }
}
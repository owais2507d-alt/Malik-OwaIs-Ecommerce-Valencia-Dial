<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * 1. Forgot Password Form View Render
     */
    public function showForgotForm()
    {
        return view('user.auth.forgot-password');
    }

    /**
     * 2. Process Forgot Password - Send Reset Link via Email
     */
    public function sendResetLink(Request $request)
    {
        // Strict Validation for secure link distribution
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This email address is not registered in our elite vault.'
        ]);

        // Broker interactions to trigger Laravel standard token setup
        $status = Password::sendResetLink($request->only('email'));

        // If successfully dispatched, bounce back with a success banner
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function showResetForm(string $token)
    {
        return view('user.auth.reset-password', ['token' => $token]);
    }

    
    public function updatePassword(Request $request)
    {
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
            ? redirect()->route('user.login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
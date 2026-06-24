<?php

namespace App\Http\Controllers\Admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }
    // handle login  request

public function login(Request $request)
{
    Log::info('Admin login request received.', [
        'email' => $request->email,
        'remember' => $request->boolean('remember'),
    ]);

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    Log::info('Credentials validated.', [
        'email' => $credentials['email'],
    ]);

    try {
        Log::info('Attempting admin authentication...', [
            'guard' => 'admin',
        ]);

        if (Auth::guard('admin')->attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            Log::info('Admin authentication successful.');

            $request->session()->regenerate();

            Log::info('Session regenerated.', [
                'admin_id' => Auth::guard('admin')->id(),
                'admin_email' => Auth::guard('admin')->user()->email,
            ]);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Welcome back, Administrator.');
        }

        Log::warning('Admin authentication failed.', [
            'email' => $credentials['email'],
        ]);

    } catch (\Exception $e) {

        Log::error('Admin authentication exception occurred.', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        throw $e;
    }

    return redirect()
        ->route('admin.login')
        ->withErrors([
            'email' => 'The provided admin credentials are incorrect.',
        ])
        ->onlyInput('email');
}

public function logout(Request $request)
{
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login')
                     ->with('success', 'Logout successful');
}

}

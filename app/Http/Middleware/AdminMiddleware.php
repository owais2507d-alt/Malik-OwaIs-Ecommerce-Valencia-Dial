<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Agar user logged in hai aur uska role admin hai, toh hi aage jaane do
        if (
            Auth::guard('admin')->check()
        ) {
            return $next($request);
        }

        // Agar normal user yahan aane ki koshish kare, toh usko naye Admin Login par pheko
        return redirect()->route('admin.login')->withErrors([
            'email' => 'Administrative clearance required to access this terminal.',
        ]);
    }
}

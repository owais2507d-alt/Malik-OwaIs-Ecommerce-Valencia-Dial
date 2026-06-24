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
    if (
        $request->routeIs('admin.login') ||
        $request->routeIs('admin.login.submit')
    ) {
        return $next($request);
    }

    if (Auth::guard('admin')->check()) {
        return $next($request);
    }

    return redirect()->route('admin.login');
}
}

<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Always allow admin routes and health check
        if ($request->is('admin*') || $request->is('up')) {
            return $next($request);
        }

        $maintenance = Setting::getValue('maintenance_mode', '0');

        if ($maintenance !== '1') {
            return $next($request);
        }

        // Allow authenticated admin users to browse the frontend
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Allow whitelisted IPs
        $whitelist = Setting::getValue('maintenance_whitelist_ips', '');
        if ($whitelist) {
            $ips = array_map('trim', explode(',', $whitelist));
            if (in_array($request->ip(), $ips)) {
                return $next($request);
            }
        }

        $message = Setting::getValue('maintenance_message', '');
        $endTime = Setting::getValue('maintenance_end_time', '');

        return response()->view('errors.503', compact('message', 'endTime'), 503);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenanceMode = Setting::getValue('maintenance_mode', '0');
        $maintenanceMessage = Setting::getValue('maintenance_message', '');
        $maintenanceEndTime = Setting::getValue('maintenance_end_time', '');
        $whitelistIps = Setting::getValue('maintenance_whitelist_ips', '');

        return view('admin.maintenance.index', compact(
            'maintenanceMode', 'maintenanceMessage', 'maintenanceEndTime', 'whitelistIps'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'maintenance_mode' => 'required|in:0,1',
            'maintenance_message' => 'nullable|string|max:1000',
            'maintenance_end_time' => 'nullable|string|max:100',
            'maintenance_whitelist_ips' => 'nullable|string|max:500',
        ]);

        Setting::setValue('maintenance_mode', $request->maintenance_mode);
        Setting::setValue('maintenance_message', $request->maintenance_message ?? '');
        Setting::setValue('maintenance_end_time', $request->maintenance_end_time ?? '');
        Setting::setValue('maintenance_whitelist_ips', $request->maintenance_whitelist_ips ?? '');

        $status = $request->maintenance_mode === '1' ? 'enabled' : 'disabled';

        return redirect()->route('admin.maintenance.index')->with('success', "Maintenance mode {$status} and settings saved.");
    }
}

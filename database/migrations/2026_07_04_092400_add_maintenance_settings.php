<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            ['key' => 'maintenance_message', 'value' => 'Our atelier is currently undergoing enhancements to serve you with refined precision. The timepiece vault will resume operations shortly.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_end_time', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance_whitelist_ips', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'maintenance_message',
            'maintenance_end_time',
            'maintenance_whitelist_ips',
        ])->delete();
    }
};

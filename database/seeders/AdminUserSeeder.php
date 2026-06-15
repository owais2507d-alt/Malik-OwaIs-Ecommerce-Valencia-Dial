<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'owais2507d@aptechgdn.net'], 
            [
                'name' => 'Admin Owais',
                'password' => Hash::make('admin123'), 
            ]
        );
    }
}
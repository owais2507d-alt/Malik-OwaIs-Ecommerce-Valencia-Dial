<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Valencia Admin  Owais',
            'email' => 'Owais2507d@aptechgdn.net', // <-- Aap apni marzi ki email rakh sakte hain
            'password' => Hash::make('admin1234'), // <-- Secret password
            'role' => 'admin', // <-- Yeh line aapko admin banayegi
            'is_verified' => 1 // Taaki OTP na maange seedha chal jaye
        ]);
    }
}
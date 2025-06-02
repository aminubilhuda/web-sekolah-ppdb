<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'abdira@admin.com',
            'username' => 'abdira',
            'password' => Hash::make('abdira'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
} 
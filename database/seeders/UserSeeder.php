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
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@superadmin.com',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
            'email_verified_at' => now(),
            'role' => 'super-admin',
            'status' => 'active',
        ]);
        $guru = User::create([
            'name' => 'Guru',
            'email' => 'guru@guru.com',
            'username' => 'guru',
            'password' => Hash::make('guru'),
            'email_verified_at' => now(),
            'role' => 'guru',
            'status' => 'active',
        ]);
    }
} 
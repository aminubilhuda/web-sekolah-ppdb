<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'abdira@gmail.com',
            'email_verified_at' => now(),
            'username' => 'abdira',
            'role' => 'admin',
            'status' => 'active'
        ]);

        $this->call([
            KategoriSeeder::class,
            BeritaSeeder::class
        ]);
    }
}
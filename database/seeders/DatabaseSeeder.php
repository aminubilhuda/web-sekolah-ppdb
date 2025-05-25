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
            JurusanSeeder::class,
            AgendaSeeder::class,
            AlumniSeeder::class,
            KategoriSeeder::class,
            BeritaSeeder::class,
            EkstrakurikulerSeeder::class,
            FasilitasSeeder::class,
            GuruSeeder::class,
            JurusanSeeder::class,
            KategoriPrestasiSeeder::class,
            Lk3Seeder::class,
            PpdbSeeder::class,
            PrestasiSeeder::class,
            ProfilSekolahSeeder::class,
            SiswaSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
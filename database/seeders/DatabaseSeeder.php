<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Create permissions first
            PermissionSeeder::class,
            
            // Then create roles and assign permissions
            RoleSeeder::class,
            
            // Finally create users and assign roles
            UserSeeder::class,
            
            // // Data Master
            // KategoriSeeder::class,
            // KategoriPrestasiSeeder::class,
            
            // // Data Pengguna
            // GuruSeeder::class,
            // JurusanSeeder::class,
            // KelasSeeder::class,
            // MapelSeeder::class,
            // SiswaSeeder::class,
            
            // // Data Akademik
            // NilaiSeeder::class,
            
            // // Data Sekolah
            ProfilSekolahSeeder::class,
            // FasilitasSeeder::class,
            // EkstrakurikulerSeeder::class,
            // MitraIndustriSeeder::class,
            
            // // Data Konten
            // BeritaSeeder::class,
            // PengumumanSeeder::class,
            // AgendaSeeder::class,
            // GaleriSeeder::class,
            // SliderSeeder::class,
            
            // // Data PPDB
            // PpdbInfoSeeder::class,
            // PpdbSeeder::class,
            
            // // Data Prestasi
            // PrestasiSeeder::class,
            // AlumniSeeder::class,
            // Lk3Seeder::class,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $nilai = [
            [
                'siswa_id' => 1,
                'mapel_id' => 1, // Matematika
                'nilai_angka' => 85.50,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 1,
                'mapel_id' => 2, // Bahasa Indonesia
                'nilai_angka' => 88.75,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 1,
                'mapel_id' => 3, // Bahasa Inggris
                'nilai_angka' => 90.00,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'mapel_id' => 1, // Matematika
                'nilai_angka' => 87.25,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'mapel_id' => 2, // Bahasa Indonesia
                'nilai_angka' => 86.50,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'siswa_id' => 2,
                'mapel_id' => 3, // Bahasa Inggris
                'nilai_angka' => 89.75,
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2023/2024',
                'kurikulum' => 'Merdeka',
                'keterangan' => 'Sangat Baik',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('nilai')->insert($nilai);
    }
} 
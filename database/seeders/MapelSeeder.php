<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'BIG',
                'nama_mapel' => 'Bahasa Inggris',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'PKN',
                'nama_mapel' => 'Pendidikan Kewarganegaraan',
                'kkm' => 75,
                'jumlah_jam' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'SEJ',
                'nama_mapel' => 'Sejarah Indonesia',
                'kkm' => 75,
                'jumlah_jam' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'SEN',
                'nama_mapel' => 'Seni Budaya',
                'kkm' => 75,
                'jumlah_jam' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'PJK',
                'nama_mapel' => 'Pendidikan Jasmani dan Kesehatan',
                'kkm' => 75,
                'jumlah_jam' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam',
                'kkm' => 75,
                'jumlah_jam' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'FIS',
                'nama_mapel' => 'Fisika',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'KIM',
                'nama_mapel' => 'Kimia',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'BIO',
                'nama_mapel' => 'Biologi',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'EKO',
                'nama_mapel' => 'Ekonomi',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'GEO',
                'nama_mapel' => 'Geografi',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_mapel' => 'SOS',
                'nama_mapel' => 'Sosiologi',
                'kkm' => 75,
                'jumlah_jam' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mapel')->insert($mapel);
    }
} 
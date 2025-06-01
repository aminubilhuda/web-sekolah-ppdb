<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'deskripsi' => 'Jurusan yang mempelajari tentang pengembangan perangkat lunak, pemrograman, dan teknologi informasi.',
                'gambar' => 'jurusan/rpl.jpg',
                'kuota' => 100,
                'kepala_jurusan_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jurusan')->insert($jurusan);
    }
}
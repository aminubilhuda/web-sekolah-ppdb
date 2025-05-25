<?php

namespace Database\Seeders;

use App\Models\KategoriPrestasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriPrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Akademik',
                'slug' => Str::slug('Akademik'),
                'deskripsi' => 'Prestasi dalam bidang akademik seperti olimpiade sains, matematika, dan kompetisi akademik lainnya.',
            ],
            [
                'nama' => 'Non-Akademik',
                'slug' => Str::slug('Non-Akademik'),
                'deskripsi' => 'Prestasi dalam bidang non-akademik seperti olahraga, seni, dan kegiatan ekstrakurikuler.',
            ],
            [
                'nama' => 'Kejuaraan Umum',
                'slug' => Str::slug('Kejuaraan Umum'),
                'deskripsi' => 'Prestasi dalam berbagai kejuaraan umum tingkat nasional dan internasional.',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriPrestasi::create($kategori);
        }
    }
} 
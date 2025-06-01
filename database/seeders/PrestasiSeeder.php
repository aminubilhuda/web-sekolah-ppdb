<?php

namespace Database\Seeders;

use App\Models\Prestasi;
use App\Models\KategoriPrestasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriAkademik = KategoriPrestasi::where('nama', 'Akademik')->first();
        $kategoriNonAkademik = KategoriPrestasi::where('nama', 'Non-Akademik')->first();
        $kategoriUmum = KategoriPrestasi::where('nama', 'Kejuaraan Umum')->first();

        $prestasis = [
            [
                'judul' => 'Juara 1 Olimpiade Matematika Tingkat Provinsi',
                'slug' => Str::slug('Juara 1 Olimpiade Matematika Tingkat Provinsi'),
                'deskripsi' => 'Meraih juara 1 dalam Olimpiade Matematika tingkat Provinsi Jawa Barat tahun 2024.',
                'gambar' => 'prestasi/olimpiade-matematika.jpg',
                'tanggal' => '2024-02-15',
                'kategori_id' => $kategoriAkademik->id,
                'is_published' => true,
            ],
            [
                'judul' => 'Juara 2 Turnamen Basket Antar Sekolah',
                'slug' => Str::slug('Juara 2 Turnamen Basket Antar Sekolah'),
                'deskripsi' => 'Meraih juara 2 dalam Turnamen Basket Antar Sekolah tingkat Kota tahun 2024.',
                'gambar' => 'prestasi/turnamen-basket.jpg',
                'tanggal' => '2024-03-10',
                'kategori_id' => $kategoriNonAkademik->id,
                'is_published' => true,
            ],
            [
                'judul' => 'Juara 1 Lomba Karya Tulis Ilmiah',
                'slug' => Str::slug('Juara 1 Lomba Karya Tulis Ilmiah'),
                'deskripsi' => 'Meraih juara 1 dalam Lomba Karya Tulis Ilmiah tingkat Nasional tahun 2024.',
                'gambar' => 'prestasi/karya-tulis.jpg',
                'tanggal' => '2024-01-20',
                'kategori_id' => $kategoriUmum->id,
                'is_published' => true,
            ],
        ];

        foreach ($prestasis as $prestasi) {
            Prestasi::create($prestasi);
        }
    }
} 
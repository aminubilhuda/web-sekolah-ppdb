<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            [
                'nama' => 'Berita Sekolah',
                'deskripsi' => 'Berita seputar kegiatan dan informasi sekolah'
            ],
            [
                'nama' => 'Prestasi',
                'deskripsi' => 'Berita tentang prestasi siswa dan sekolah'
            ],
            [
                'nama' => 'Kegiatan',
                'deskripsi' => 'Berita tentang kegiatan-kegiatan yang dilaksanakan di sekolah'
            ],
            [
                'nama' => 'Pengumuman',
                'deskripsi' => 'Pengumuman resmi dari sekolah'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori['nama'],
                'slug' => Str::slug($kategori['nama']),
                'deskripsi' => $kategori['deskripsi']
            ]);
        }
    }
} 
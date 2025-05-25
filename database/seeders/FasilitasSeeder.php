<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FasilitasSeeder extends Seeder
{
    public function run()
    {
        $fasilitas = [
            [
                'nama' => 'Laboratorium Komputer',
                'deskripsi' => 'Laboratorium komputer dengan peralatan modern untuk pembelajaran teknologi informasi'
            ],
            [
                'nama' => 'Laboratorium Bahasa',
                'deskripsi' => 'Laboratorium bahasa untuk meningkatkan kemampuan berbahasa asing siswa'
            ],
            [
                'nama' => 'Perpustakaan',
                'deskripsi' => 'Perpustakaan dengan koleksi buku yang lengkap dan ruang baca yang nyaman'
            ],
            [
                'nama' => 'Lapangan Olahraga',
                'deskripsi' => 'Lapangan olahraga yang luas untuk berbagai kegiatan olahraga'
            ],
            [
                'nama' => 'Ruang Multimedia',
                'deskripsi' => 'Ruang multimedia untuk pembelajaran interaktif'
            ],
            [
                'nama' => 'Musholla',
                'deskripsi' => 'Tempat ibadah yang nyaman untuk siswa dan guru'
            ],
            [
                'nama' => 'Kantin Sehat',
                'deskripsi' => 'Kantin dengan makanan dan minuman yang sehat dan bergizi'
            ],
            [
                'nama' => 'Ruang UKS',
                'deskripsi' => 'Unit Kesehatan Sekolah untuk pelayanan kesehatan siswa'
            ]
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::create([
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'deskripsi' => $item['deskripsi'],
                'status' => 'active'
            ]);
        }
    }
} 
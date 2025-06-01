<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        $galeri = [
            [
                'judul' => 'Kegiatan Praktikum Lab Komputer',
                'deskripsi' => 'Siswa sedang melakukan praktikum di laboratorium komputer',
                'gambar' => 'galeri/praktikum-lab.jpg',
                'jenis' => 'foto',
                'url_video' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Upacara Bendera',
                'deskripsi' => 'Kegiatan upacara bendera rutin setiap hari Senin',
                'gambar' => 'galeri/upacara.jpg',
                'jenis' => 'foto',
                'url_video' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kunjungan Industri',
                'deskripsi' => 'Siswa melakukan kunjungan ke perusahaan mitra',
                'gambar' => 'galeri/kunjungan-industri.jpg',
                'jenis' => 'foto',
                'url_video' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kegiatan Ekstrakurikuler',
                'deskripsi' => 'Siswa berlatih dalam kegiatan ekstrakurikuler',
                'gambar' => 'galeri/ekstrakurikuler.jpg',
                'jenis' => 'foto',
                'url_video' => null,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Video Profil Sekolah',
                'deskripsi' => 'Video profil sekolah yang menampilkan berbagai fasilitas dan kegiatan',
                'gambar' => 'galeri/thumbnail-profil.jpg',
                'jenis' => 'video',
                'url_video' => 'https://www.youtube.com/watch?v=example',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('galeri')->insert($galeri);
    }
} 
<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $beritas = [
            [
                'judul' => 'Pembukaan PPDB Tahun Ajaran 2024/2025',
                'konten' => 'Pendaftaran Peserta Didik Baru (PPDB) tahun ajaran 2024/2025 akan dibuka pada tanggal 1 Juni 2024. Pendaftaran dilakukan secara online melalui website sekolah.',
                'kategori_id' => 4,
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'judul' => 'Siswa SMK Juara Lomba Coding Nasional',
                'konten' => 'Tim coding SMK berhasil meraih juara 1 dalam Lomba Coding Nasional yang diselenggarakan di Jakarta. Prestasi ini membuktikan kualitas pendidikan di bidang teknologi informasi.',
                'kategori_id' => 2,
                'status' => 'published',
                'published_at' => now()
            ],
            [
                'judul' => 'Kunjungan Industri ke PT. XYZ',
                'konten' => 'Siswa kelas XI melakukan kunjungan industri ke PT. XYZ untuk mempelajari proses produksi dan manajemen perusahaan. Kunjungan ini merupakan bagian dari program pembelajaran di luar kelas.',
                'kategori_id' => 3,
                'status' => 'published',
                'published_at' => now()
            ]
        ];

        foreach ($beritas as $berita) {
            Berita::create([
                'judul' => $berita['judul'],
                'slug' => Str::slug($berita['judul']),
                'konten' => $berita['konten'],
                'kategori_id' => $berita['kategori_id'],
                'status' => $berita['status'],
                'published_at' => $berita['published_at']
            ]);
        }
    }
} 
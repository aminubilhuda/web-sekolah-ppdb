<?php

namespace Database\Seeders;

use App\Models\Lk3;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Lk3Seeder extends Seeder
{
    public function run(): void
    {
        $lk3s = [
            [
                'judul' => 'Laporan Kinerja Tahunan 2023',
                'slug' => Str::slug('Laporan Kinerja Tahunan 2023'),
                'deskripsi' => 'Laporan kinerja sekolah tahun 2023 yang mencakup pencapaian akademik dan non-akademik.',
                'file_path' => 'lk3/laporan-kinerja-2023.pdf',
                'tahun' => '2023',
                'status' => 'published',
            ],
            [
                'judul' => 'Laporan Keuangan Semester 1 2024',
                'slug' => Str::slug('Laporan Keuangan Semester 1 2024'),
                'deskripsi' => 'Laporan keuangan sekolah untuk semester 1 tahun 2024.',
                'file_path' => 'lk3/laporan-keuangan-2024-s1.pdf',
                'tahun' => '2024',
                'status' => 'published',
            ],
            [
                'judul' => 'Laporan Program Kerja 2024',
                'slug' => Str::slug('Laporan Program Kerja 2024'),
                'deskripsi' => 'Laporan program kerja sekolah untuk tahun 2024.',
                'file_path' => 'lk3/program-kerja-2024.pdf',
                'tahun' => '2024',
                'status' => 'draft',
            ],
        ];

        foreach ($lk3s as $lk3) {
            Lk3::create($lk3);
        }
    }
} 
<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    public function run(): void
    {
        $ekstrakurikulers = [
            [
                'nama_ekstrakurikuler' => 'Robotik',
                'deskripsi' => 'Ekstrakurikuler robotik untuk mengembangkan kemampuan dalam bidang teknologi dan pemrograman robot.',
                'gambar' => 'ekstrakurikuler/robotik.jpg',
                'pembina' => 'Budi Santoso, S.T.',
                'status' => true,
            ],
            [
                'nama_ekstrakurikuler' => 'English Club',
                'deskripsi' => 'Ekstrakurikuler bahasa Inggris untuk meningkatkan kemampuan berbahasa Inggris siswa.',
                'gambar' => 'ekstrakurikuler/english-club.jpg',
                'pembina' => 'Sarah Johnson, M.Ed.',
                'status' => true,
            ],
            [
                'nama_ekstrakurikuler' => 'Basket',
                'deskripsi' => 'Ekstrakurikuler basket untuk mengembangkan bakat dan minat siswa dalam olahraga basket.',
                'gambar' => 'ekstrakurikuler/basket.jpg',
                'pembina' => 'Ahmad Rizki, S.Pd.',
                'status' => true,
            ],
        ];

        foreach ($ekstrakurikulers as $ekstrakurikuler) {
            Ekstrakurikuler::create($ekstrakurikuler);
        }
    }
} 
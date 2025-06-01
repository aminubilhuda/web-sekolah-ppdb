<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'judul' => 'Selamat Datang di Website Sekolah Kami',
                'deskripsi' => 'Sekolah unggulan dengan fasilitas modern dan tenaga pengajar profesional',
                'image' => 'sliders/welcome.jpg',
                'link' => '/profil',
                'is_published' => true,
                'order' => 1,
                'is_active' => true
            ],
            [
                'judul' => 'Penerimaan Peserta Didik Baru 2024',
                'deskripsi' => 'Daftar sekarang dan bergabunglah bersama kami',
                'image' => 'sliders/ppdb.jpg',
                'link' => '/ppdb',
                'is_published' => true,
                'order' => 2,
                'is_active' => true
            ],
            [
                'judul' => 'Fasilitas Modern',
                'deskripsi' => 'Dilengkapi dengan laboratorium dan perpustakaan digital',
                'image' => 'sliders/fasilitas.jpg',
                'link' => '/profil/fasilitas',
                'is_published' => true,
                'order' => 3,
                'is_active' => true
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
} 
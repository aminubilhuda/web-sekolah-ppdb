<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusan = [
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'singkatan' => 'TKJ',
                'deskripsi' => 'Jurusan yang mempelajari tentang jaringan komputer dan sistem informasi',
                'gambar' => 'jurusan1.jpg',
                'status' => true,
            ],
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'deskripsi' => 'Jurusan yang mempelajari tentang pengembangan perangkat lunak',
                'gambar' => 'jurusan2.jpg',
                'status' => true,
            ],
            [
                'nama_jurusan' => 'Multimedia',
                'singkatan' => 'MM',
                'deskripsi' => 'Jurusan yang mempelajari tentang desain grafis dan multimedia',
                'gambar' => 'jurusan3.jpg',
                'status' => true,
            ],
            [
                'nama_jurusan' => 'Teknik Elektronika',
                'singkatan' => 'TE',
                'deskripsi' => 'Jurusan yang mempelajari tentang elektronika dan sistem kontrol',
                'gambar' => 'jurusan4.jpg',
                'status' => true,
            ],
        ];

        foreach ($jurusan as $j) {
            Jurusan::create($j);
        }
    }
}
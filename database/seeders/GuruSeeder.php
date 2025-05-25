<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guru = [
            [
                'nama' => 'Budi Santoso',
                'nip' => '198501012010011001',
                'jabatan' => 'Guru TKJ',
                'bidang_studi' => 'Jaringan Komputer',
                'status' => true,
            ],
            [
                'nama' => 'Ani Wijaya',
                'nip' => '198602022010011002',
                'jabatan' => 'Guru RPL',
                'bidang_studi' => 'Pemrograman Web',
                'status' => true,
            ],
            [
                'nama' => 'Dewi Putri',
                'nip' => '198703032010011003',
                'jabatan' => 'Guru Multimedia',
                'bidang_studi' => 'Desain Grafis',
                'status' => true,
            ],
            [
                'nama' => 'Rudi Hartono',
                'nip' => '198804042010011004',
                'jabatan' => 'Guru Elektronika',
                'bidang_studi' => 'Elektronika Dasar',
                'status' => true,
            ],
        ];

        foreach ($guru as $g) {
            Guru::create($g);
        }
    }
}

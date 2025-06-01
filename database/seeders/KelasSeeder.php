<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil data jurusan
        $jurusanRPL = Jurusan::where('nama_jurusan', 'Rekayasa Perangkat Lunak')->first();
        $jurusanMM = Jurusan::where('nama_jurusan', 'Multimedia')->first();
        $jurusanTKJ = Jurusan::where('nama_jurusan', 'Teknik Komputer dan Jaringan')->first();

        $kelas = [
            // Kelas RPL
            [
                'nama_kelas' => 'X RPL 1',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Rekayasa Perangkat Lunak 1',
                'jurusan_id' => $jurusanRPL->id,
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'X RPL 2',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Rekayasa Perangkat Lunak 2',
                'jurusan_id' => $jurusanRPL->id,
                'guru_id' => '1',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI RPL 1',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Rekayasa Perangkat Lunak 1',
                'jurusan_id' => $jurusanRPL->id,
                'guru_id' => '2',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI RPL 2',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Rekayasa Perangkat Lunak 2',
                'jurusan_id' => $jurusanRPL->id,
                'guru_id' => '3',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII RPL 1',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Rekayasa Perangkat Lunak 1',
                'jurusan_id' => $jurusanRPL->id,
                'guru_id' => '4',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII RPL 2',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Rekayasa Perangkat Lunak 2',
                'jurusan_id' => $jurusanRPL->id,
                'guru_id' => '1',
                'is_active' => true,
            ],

            // Kelas MM
            [
                'nama_kelas' => 'X MM 1',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Multimedia 1',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '2',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'X MM 2',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Multimedia 2',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '3',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI MM 1',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Multimedia 1',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '4',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI MM 2',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Multimedia 2',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '1',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII MM 1',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Multimedia 1',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '2',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII MM 2',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Multimedia 2',
                'jurusan_id' => $jurusanMM->id,
                'guru_id' => '3',
                'is_active' => true,
            ],

            // Kelas TKJ
            [
                'nama_kelas' => 'X TKJ 1',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Teknik Komputer dan Jaringan 1',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '4',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'X TKJ 2',
                'tingkat' => 'X',
                'deskripsi' => 'Kelas X Teknik Komputer dan Jaringan 2',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '1',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI TKJ 1',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Teknik Komputer dan Jaringan 1',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '2',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XI TKJ 2',
                'tingkat' => 'XI',
                'deskripsi' => 'Kelas XI Teknik Komputer dan Jaringan 2',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '3',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII TKJ 1',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Teknik Komputer dan Jaringan 1',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '4',
                'is_active' => true,
            ],
            [
                'nama_kelas' => 'XII TKJ 2',
                'tingkat' => 'XII',
                'deskripsi' => 'Kelas XII Teknik Komputer dan Jaringan 2',
                'jurusan_id' => $jurusanTKJ->id,
                'guru_id' => '1',
                'is_active' => true,
            ],
        ];

        foreach ($kelas as $data) {
            Kelas::create($data);
        }
    }
} 
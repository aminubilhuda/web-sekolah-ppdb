<?php

namespace Database\Seeders;

use App\Models\Ppdb;
use Illuminate\Database\Seeder;

class PpdbSeeder extends Seeder
{
    public function run(): void
    {
        $ppdbs = [
            [
                'nama_lengkap' => 'Ahmad Rizki',
                'nisn' => '1234567890',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'nama_ortu' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'asal_sekolah' => 'SMP Negeri 1 Jakarta',
                'jurusan_pilihan' => 'Rekayasa Perangkat Lunak',
                'foto' => 'ppdb/ahmad-rizki.jpg',
                'ijazah' => 'ppdb/ahmad-rizki-ijazah.pdf',
                'kk' => 'ppdb/ahmad-rizki-kk.pdf',
                'status' => 'Menunggu',
            ],
            [
                'nama_lengkap' => 'Siti Nurul',
                'nisn' => '1234567891',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-08-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Asia Afrika No. 78, Bandung',
                'nama_ortu' => 'Ahmad Hidayat',
                'no_hp' => '081234567891',
                'asal_sekolah' => 'SMP Negeri 2 Bandung',
                'jurusan_pilihan' => 'Multimedia',
                'foto' => 'ppdb/siti-nurul.jpg',
                'ijazah' => 'ppdb/siti-nurul-ijazah.pdf',
                'kk' => 'ppdb/siti-nurul-kk.pdf',
                'status' => 'Diterima',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nisn' => '1234567892',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Basuki Rahmat No. 56, Surabaya',
                'nama_ortu' => 'Siti Aminah',
                'no_hp' => '081234567892',
                'asal_sekolah' => 'SMP Negeri 3 Surabaya',
                'jurusan_pilihan' => 'Teknik Komputer dan Jaringan',
                'foto' => 'ppdb/budi-santoso.jpg',
                'ijazah' => 'ppdb/budi-santoso-ijazah.pdf',
                'kk' => 'ppdb/budi-santoso-kk.pdf',
                'status' => 'Ditolak',
            ],
        ];

        foreach ($ppdbs as $ppdb) {
            Ppdb::create($ppdb);
        }
    }
} 
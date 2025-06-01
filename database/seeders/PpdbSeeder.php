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
                'nik' => '3171234567890001',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'no_hp' => '081234567890',
                'asal_sekolah' => 'SMP Negeri 1 Jakarta',
                'tahun_lulus' => '2024',
                'nama_ayah' => 'Budi Santoso',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '081234567891',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ibu' => 'Guru',
                'no_hp_ibu' => '081234567892',
                'alamat_ortu' => 'Jl. Merdeka No. 123, Jakarta',
                'jurusan_pilihan' => '1',
                'foto' => 'ppdb/ahmad-rizki.jpg',
                'ijazah' => 'ppdb/ahmad-rizki-ijazah.pdf',
                'kk' => 'ppdb/ahmad-rizki-kk.pdf',
                'status' => 'Menunggu',
            ],
            [
                'nama_lengkap' => 'Siti Nurul',
                'nisn' => '1234567891',
                'nik' => '3171234567890002',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-08-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Asia Afrika No. 78, Bandung',
                'no_hp' => '081234567893',
                'asal_sekolah' => 'SMP Negeri 2 Bandung',
                'tahun_lulus' => '2024',
                'nama_ayah' => 'Ahmad Hidayat',
                'pekerjaan_ayah' => 'PNS',
                'no_hp_ayah' => '081234567894',
                'nama_ibu' => 'Nurul Hidayah',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_hp_ibu' => '081234567895',
                'alamat_ortu' => 'Jl. Asia Afrika No. 78, Bandung',
                'jurusan_pilihan' => '2',
                'foto' => 'ppdb/siti-nurul.jpg',
                'ijazah' => 'ppdb/siti-nurul-ijazah.pdf',
                'kk' => 'ppdb/siti-nurul-kk.pdf',
                'status' => 'Diterima',
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'nisn' => '1234567892',
                'nik' => '3171234567890003',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Basuki Rahmat No. 56, Surabaya',
                'no_hp' => '081234567896',
                'asal_sekolah' => 'SMP Negeri 3 Surabaya',
                'tahun_lulus' => '2024',
                'nama_ayah' => 'Slamet Riyadi',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '081234567897',
                'nama_ibu' => 'Siti Fatimah',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_hp_ibu' => '081234567898',
                'alamat_ortu' => 'Jl. Basuki Rahmat No. 56, Surabaya',
                'jurusan_pilihan' => '3',
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
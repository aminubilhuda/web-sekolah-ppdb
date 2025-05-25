<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = [
            [
                'nama' => 'Ahmad Rizki',
                'nis' => '2024001',
                'nisn' => '1234567890',
                'nik' => '1234567890123456',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-05-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'kelas' => 'X RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'nama_ayah' => 'Budi Santoso',
                'nik_ayah' => '1234567890123457',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '081234567890',
                'nama_ibu' => 'Siti Aminah',
                'nik_ibu' => '1234567890123458',
                'pekerjaan_ibu' => 'Guru',
                'no_hp_ibu' => '081234567891',
                'foto' => 'siswa/ahmad-rizki.jpg',
                'status' => true,
            ],
            [
                'nama' => 'Siti Nurul',
                'nis' => '2024002',
                'nisn' => '1234567891',
                'nik' => '1234567890123459',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2008-08-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'alamat' => 'Jl. Asia Afrika No. 78, Bandung',
                'kelas' => 'X MM 1',
                'jurusan' => 'Multimedia',
                'nama_ayah' => 'Ahmad Hidayat',
                'nik_ayah' => '1234567890123460',
                'pekerjaan_ayah' => 'PNS',
                'no_hp_ayah' => '081234567892',
                'nama_ibu' => 'Nur Hidayah',
                'nik_ibu' => '1234567890123461',
                'pekerjaan_ibu' => 'Wiraswasta',
                'no_hp_ibu' => '081234567893',
                'foto' => 'siswa/siti-nurul.jpg',
                'status' => true,
            ],
            [
                'nama' => 'Budi Santoso',
                'nis' => '2024003',
                'nisn' => '1234567892',
                'nik' => '1234567890123462',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'alamat' => 'Jl. Basuki Rahmat No. 56, Surabaya',
                'kelas' => 'X TKJ 1',
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'nama_ayah' => 'Slamet Riyadi',
                'nik_ayah' => '1234567890123463',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '081234567894',
                'nama_ibu' => 'Siti Fatimah',
                'nik_ibu' => '1234567890123464',
                'pekerjaan_ibu' => 'PNS',
                'no_hp_ibu' => '081234567895',
                'foto' => 'siswa/budi-santoso.jpg',
                'status' => true,
            ],
        ];

        foreach ($siswas as $siswa) {
            Siswa::create($siswa);
        }
    }
} 
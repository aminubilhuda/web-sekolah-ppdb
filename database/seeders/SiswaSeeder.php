<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = Jurusan::first();
        $kelas = Kelas::first();

        if (!$jurusan || !$kelas) {
            $this->command->error('Jurusan atau Kelas belum ada. Silakan jalankan JurusanSeeder dan KelasSeeder terlebih dahulu.');
            return;
        }

        $siswa = [
            [
                'nama' => 'Ahmad Rizki',
                'nis' => '2024001',
                'nisn' => '1234567890',
                'nik' => '1234567890123456',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-01-15',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'jurusan_id' => $jurusan->id,
                'kelas_id' => $kelas->id,
                'tahun_masuk' => '2024',
                'nama_ayah' => 'Budi Santoso',
                'nik_ayah' => '1234567890123457',
                'pekerjaan_ayah' => 'Wiraswasta',
                'no_hp_ayah' => '081234567890',
                'nama_ibu' => 'Siti Aminah',
                'nik_ibu' => '1234567890123458',
                'pekerjaan_ibu' => 'Guru',
                'no_hp_ibu' => '081234567891',
                'nama_wali' => 'Ahmad Hadi',
                'nik_wali' => '1234567890123459',
                'pekerjaan_wali' => 'Pedagang',
                'no_hp_wali' => '081234567892',
                'hubungan_wali' => 'Paman',
                'foto' => null,
                'is_active' => true,
                'deskripsi' => 'Siswa berprestasi di bidang akademik',
                'no_hp' => '081234567893',
                'email' => 'ahmad.rizki@example.com',
            ],
            [
                'nama' => 'Siti Nurul',
                'nis' => '2024002',
                'nisn' => '1234567891',
                'nik' => '1234567890123460',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2006-03-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Asia Afrika No. 45, Bandung',
                'jurusan_id' => $jurusan->id,
                'kelas_id' => $kelas->id,
                'tahun_masuk' => '2024',
                'nama_ayah' => 'Hasan Basri',
                'nik_ayah' => '1234567890123461',
                'pekerjaan_ayah' => 'PNS',
                'no_hp_ayah' => '081234567894',
                'nama_ibu' => 'Fatimah',
                'nik_ibu' => '1234567890123462',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_hp_ibu' => '081234567895',
                'nama_wali' => 'Rudi Hartono',
                'nik_wali' => '1234567890123463',
                'pekerjaan_wali' => 'Wiraswasta',
                'no_hp_wali' => '081234567896',
                'hubungan_wali' => 'Paman',
                'foto' => null,
                'is_active' => true,
                'deskripsi' => 'Siswa berprestasi di bidang non-akademik',
                'no_hp' => '081234567897',
                'email' => 'siti.nurul@example.com',
            ],
        ];

        foreach ($siswa as $data) {
            Siswa::create($data);
        }
    }
} 
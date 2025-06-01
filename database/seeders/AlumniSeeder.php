<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $jurusan = Jurusan::first();

        $alumnis = [
            [
                'nis' => '2021001',
                'nisn' => '1234567890',
                'nama' => 'Ahmad Rizki',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2003-05-15',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'no_hp' => '081234567890',
                'email' => 'ahmad.rizki@email.com',
                'foto' => 'alumni1.jpg',
                'jurusan_id' => $jurusan->id,
                'tahun_lulus' => 2021,
                'status_bekerja' => true,
                'nama_perusahaan' => 'PT Teknologi Indonesia',
                'jabatan' => 'Software Developer',
                'alamat_perusahaan' => 'Jl. Sudirman No. 45, Jakarta',
                'status_kuliah' => false,
                'testimoni' => 'Sekolah ini memberikan fondasi yang kuat untuk karir saya di bidang teknologi.',
                'status' => true,
            ],
            [
                'nis' => '2021002',
                'nisn' => '1234567891',
                'nama' => 'Siti Nurul',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2003-08-20',
                'agama' => 'Islam',
                'alamat' => 'Jl. Asia Afrika No. 78, Bandung',
                'no_hp' => '081234567891',
                'email' => 'siti.nurul@email.com',
                'foto' => 'alumni2.jpg',
                'jurusan_id' => $jurusan->id,
                'tahun_lulus' => 2021,
                'status_bekerja' => false,
                'status_kuliah' => true,
                'nama_kampus' => 'Universitas Indonesia',
                'jurusan_kuliah' => 'Teknik Informatika',
                'tahun_masuk' => 2021,
                'testimoni' => 'Pengalaman belajar di sekolah ini sangat berharga untuk persiapan kuliah saya.',
                'status' => true,
            ],
            [
                'nis' => '2021003',
                'nisn' => '1234567892',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2003-03-10',
                'agama' => 'Islam',
                'alamat' => 'Jl. Basuki Rahmat No. 56, Surabaya',
                'no_hp' => '081234567892',
                'email' => 'budi.santoso@email.com',
                'foto' => 'alumni3.jpg',
                'jurusan_id' => $jurusan->id,
                'tahun_lulus' => 2021,
                'status_bekerja' => true,
                'nama_perusahaan' => 'PT Digital Solutions',
                'jabatan' => 'Network Engineer',
                'alamat_perusahaan' => 'Jl. Gatot Subroto No. 90, Jakarta',
                'status_kuliah' => true,
                'nama_kampus' => 'Institut Teknologi Bandung',
                'jurusan_kuliah' => 'Teknik Komputer',
                'tahun_masuk' => 2021,
                'testimoni' => 'Sekolah ini memberikan kesempatan untuk mengembangkan skill teknis dan soft skill yang sangat berguna.',
                'status' => true,
            ],
        ];

        foreach ($alumnis as $alumni) {
            Alumni::create($alumni);
        }
    }
} 
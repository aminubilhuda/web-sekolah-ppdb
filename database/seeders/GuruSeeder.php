<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID mapel
        $pemrograman = Mapel::where('nama_mapel', 'Pemrograman Dasar')->first();
        $web = Mapel::where('nama_mapel', 'Pemrograman Web')->first();
        $desain = Mapel::where('nama_mapel', 'Desain Grafis')->first();
        $jaringan = Mapel::where('nama_mapel', 'Komputer dan Jaringan Dasar')->first();

        $guru = [
            [
                'nama' => 'Ahmad Rizki',
                'nip' => '198501012010011001',
                'jabatan' => 'Guru Mapel',
                'bidang_studi' => 'Pemrograman',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
                'no_hp' => '081234567890',
                'email' => 'ahmad.rizki@example.com',
                'is_active' => true,
                'deskripsi' => 'Guru pemrograman dengan pengalaman 10 tahun mengajar.',
            ],
            [
                'nama' => 'Siti Nurul',
                'nip' => '198602022010012002',
                'jabatan' => 'Guru Mapel',
                'bidang_studi' => 'Desain Grafis',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1986-02-02',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kreatif No. 2, Bandung',
                'no_hp' => '081234567891',
                'email' => 'siti.nurul@example.com',
                'is_active' => true,
                'deskripsi' => 'Guru desain grafis dengan keahlian dalam Adobe Creative Suite.',
            ],
            [
                'nama' => 'Budi Santoso',
                'nip' => '198703032010011003',
                'jabatan' => 'Guru Mapel',
                'bidang_studi' => 'Jaringan',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1987-03-03',
                'agama' => 'Islam',
                'alamat' => 'Jl. Teknologi No. 3, Surabaya',
                'no_hp' => '081234567892',
                'email' => 'budi.santoso@example.com',
                'is_active' => true,
                'deskripsi' => 'Guru jaringan dengan sertifikasi CCNA.',
            ],
            [
                'nama' => 'Dewi Lestari',
                'nip' => '198804042010012004',
                'jabatan' => 'Guru Mapel',
                'bidang_studi' => 'Pemrograman Web',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1988-04-04',
                'agama' => 'Islam',
                'alamat' => 'Jl. Digital No. 4, Yogyakarta',
                'no_hp' => '081234567893',
                'email' => 'dewi.lestari@example.com',
                'is_active' => true,
                'deskripsi' => 'Guru pemrograman web dengan keahlian dalam framework modern.',
            ],
        ];

        foreach ($guru as $data) {
            Guru::create($data);
        }
    }
}
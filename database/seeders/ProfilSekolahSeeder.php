<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilSekolah;

class ProfilSekolahSeeder extends Seeder
{
    public function run()
    {
        ProfilSekolah::create([
            'nama_sekolah' => 'SMK Negeri 1 Contoh',
            'npsn' => '12345678',
            'status' => 'Negeri',
            'jenis' => 'SMK',
            'status_akreditasi' => 'A',
            'kepala_sekolah' => 'Dr. Contoh Nama',
            'sambutan_kepala' => 'Selamat datang di website resmi SMK Negeri 1 Contoh',
            'visi' => 'Menjadi sekolah unggulan yang menghasilkan lulusan berkompeten',
            'misi' => 'Menyelenggarakan pendidikan berkualitas',
            'email' => 'info@smkn1contoh.sch.id',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Contoh No. 123',
            'provinsi' => 'Jawa Barat',
            'kabupaten' => 'Bandung',
            'kecamatan' => 'Cimahi',
            'kode_pos' => '40512',
            'website' => 'www.smkn1contoh.sch.id'
        ]);
    }
} 
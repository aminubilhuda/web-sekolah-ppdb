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
            'sejarah' => 'SMK Negeri 1 Contoh didirikan pada tahun 1990 dengan visi untuk menghasilkan lulusan yang kompeten dan siap kerja. Sejak awal berdirinya, sekolah ini telah berkomitmen untuk memberikan pendidikan berkualitas dengan fokus pada pengembangan keterampilan praktis dan pengetahuan teoritis.

Sepanjang perjalanannya, SMK Negeri 1 Contoh telah mengalami berbagai perkembangan signifikan dalam hal fasilitas, kurikulum, dan metode pembelajaran. Sekolah ini terus beradaptasi dengan perkembangan teknologi dan kebutuhan industri untuk memastikan lulusannya tetap relevan dan kompetitif di pasar kerja.',
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
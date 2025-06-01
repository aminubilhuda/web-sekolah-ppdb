<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilSekolah;

class ProfilSekolahSeeder extends Seeder
{
    public function run()
    {
        ProfilSekolah::create([
            'nama_sekolah' => 'SMK Abdi Negara Tuban',
            'slug' => 'smk-abdi-negara-tuban',
            'npsn' => '20505005',
            'status' => 'swasta',
            'jenis' => 'smk',
            'status_akreditasi' => 'a',
            'lokasi_maps' => 'https://maps.app.goo.gl/g74rKN1TvvRs8eqGA',
            'sk_pendirian' => 'SK-001/2024',
            'sk_izin_operasional' => 'SK-002/2024',
            'kepala_sekolah' => 'Uswatun Hasanah, S.Pd',
            'sambutan_kepala' => 'Selamat datang di website resmi SMK Abdi Negara Tuban',
            'sejarah' => 'SMK Abdi Negara Tuban didirikan pada tahun 2003 dengan visi untuk menghasilkan lulusan yang kompeten dan siap kerja. Sejak awal berdirinya, sekolah ini telah berkomitmen untuk memberikan pendidikan berkualitas dengan fokus pada pengembangan keterampilan praktis dan pengetahuan teoritis.

Sepanjang perjalanannya, SMK Abdi Negara Tuban telah mengalami berbagai perkembangan signifikan dalam hal fasilitas, kurikulum, dan metode pembelajaran. Sekolah ini terus beradaptasi dengan perkembangan teknologi dan kebutuhan industri untuk memastikan lulusannya tetap relevan dan kompetitif di pasar kerja.',
            'video_profile' => 'https://www.youtube.com/watch?v=GQL4Bx6mjhA',
            'visi' => 'Menjadi sekolah unggulan yang menghasilkan lulusan berkompeten',
            'misi' => 'Menyelenggarakan pendidikan berkualitas',
            'logo' => 'logo.png',
            'favicon' => 'favicon.ico',
            'email' => 'info@smkan.sch.id',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. DR. Wahidin Sudirohusodo No.798, Sidorejo',
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Tuban',
            'kecamatan' => 'Tuban',
            'kode_pos' => '62315',
            'website' => 'www.smkan.sch.id',
            'facebook' => 'https://www.facebook.com/smksabdinegaratuban',
            'instagram' => 'https://www.instagram.com/abdira_official',
            'twitter' => 'https://twitter.com/smkabdinegaratuban',
            'youtube' => 'https://www.youtube.com/@smkabdinegaratuban8825',
            'tiktok' => 'https://www.tiktok.com/@smk.abdi.negara.tuban',
            'whatsapp' => 'https://wa.me/6285708474080',
            'telegram' => 'https://t.me/smkabdinegaratuban',
            'banner_highlight' => 'banner.jpg',
            'gedung_image' => 'gedung.jpg'
        ]);
    }
} 
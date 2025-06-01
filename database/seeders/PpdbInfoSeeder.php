<?php

namespace Database\Seeders;

use App\Models\PpdbInfo;
use Illuminate\Database\Seeder;

class PpdbInfoSeeder extends Seeder
{
    public function run(): void
    {
        PpdbInfo::create([
            'judul' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2024/2025',
            'subtitle' => 'Bergabunglah bersama kami untuk masa depan yang lebih baik',
            'gambar_background' => 'ppdb/background.jpg',
            'persyaratan' => json_encode([
                'Berusia maksimal 21 tahun pada tanggal 1 Juli 2024',
                'Lulusan SMP/MTs atau sederajat',
                'Memiliki ijazah dan SKHUN',
                'Memiliki NISN',
                'Membayar biaya pendaftaran sebesar Rp 100.000'
            ]),
            'jadwal' => json_encode([
                'Pendaftaran Online' => '1 Juni - 30 Juni 2024',
                'Pengumuman Hasil' => '5 Juli 2024',
                'Daftar Ulang' => '8-10 Juli 2024',
                'Awal Masuk Sekolah' => '15 Juli 2024'
            ]),
            'panduan_pendaftaran' => 'Pendaftaran dilakukan secara online melalui website sekolah. Pastikan semua dokumen yang diperlukan sudah dipersiapkan dengan baik.',
            'langkah_pendaftaran' => json_encode([
                'Mengisi formulir pendaftaran online',
                'Mengunggah dokumen yang diperlukan',
                'Membayar biaya pendaftaran',
                'Menunggu pengumuman hasil seleksi',
                'Melakukan daftar ulang jika diterima'
            ]),
            'telepon' => '021-1234567',
            'whatsapp' => '081234567890',
            'email' => 'ppdb@smkn1contoh.sch.id'
        ]);
    }
} 
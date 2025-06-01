<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraIndustriSeeder extends Seeder
{
    public function run(): void
    {
        $mitraIndustri = [
            [
                'nama_perusahaan' => 'PT. Teknologi Maju',
                'logo' => 'mitra/tech-maju.png',
                'bidang_usaha' => 'Teknologi Informasi',
                'jenis_kerjasama' => 'Magang dan Rekrutmen',
                'deskripsi' => 'Perusahaan teknologi terkemuka yang bergerak di bidang pengembangan software dan layanan IT',
                'alamat' => 'Jl. Industri No. 123, Jakarta Selatan',
                'website' => 'https://www.techmaju.com',
                'email' => 'info@techmaju.com',
                'telepon' => '021-5551234',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'CV. Elektro Mandiri',
                'logo' => 'mitra/elektro-mandiri.png',
                'bidang_usaha' => 'Elektronika',
                'jenis_kerjasama' => 'Praktik Kerja Lapangan',
                'deskripsi' => 'Perusahaan elektronika yang memproduksi komponen elektronik dan peralatan listrik',
                'alamat' => 'Jl. Listrik No. 45, Bandung',
                'website' => 'https://www.elektromandiri.co.id',
                'email' => 'contact@elektromandiri.co.id',
                'telepon' => '022-5556789',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Otomotif Indonesia',
                'logo' => 'mitra/otomotif-indo.png',
                'bidang_usaha' => 'Otomotif',
                'jenis_kerjasama' => 'Magang dan Rekrutmen',
                'deskripsi' => 'Perusahaan otomotif yang memproduksi sparepart kendaraan dan jasa perawatan',
                'alamat' => 'Jl. Otomotif No. 67, Surabaya',
                'website' => 'https://www.otomotifindonesia.com',
                'email' => 'info@otomotifindonesia.com',
                'telepon' => '031-5559012',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_perusahaan' => 'PT. Digital Kreatif',
                'logo' => 'mitra/digital-kreatif.png',
                'bidang_usaha' => 'Desain Grafis',
                'jenis_kerjasama' => 'Praktik Kerja Lapangan',
                'deskripsi' => 'Perusahaan yang bergerak di bidang desain grafis dan multimedia',
                'alamat' => 'Jl. Kreatif No. 89, Yogyakarta',
                'website' => 'https://www.digitalkreatif.com',
                'email' => 'contact@digitalkreatif.com',
                'telepon' => '0274-5553456',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mitra_industri')->insert($mitraIndustri);
    }
} 
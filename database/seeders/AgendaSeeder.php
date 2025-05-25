<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = [
            [
                'judul' => 'Penerimaan Peserta Didik Baru Tahun 2024',
                'slug' => Str::slug('Penerimaan Peserta Didik Baru Tahun 2024'),
                'deskripsi' => 'Pendaftaran PPDB untuk tahun ajaran 2024/2025',
                'tanggal_mulai' => '2024-06-01 08:00:00',
                'tanggal_selesai' => '2024-06-30 16:00:00',
                'lokasi' => 'Aula Sekolah',
                'penanggung_jawab' => 'Budi Santoso, S.Pd.',
                'is_published' => true,
                'status' => true,
            ],
            [
                'judul' => 'Ujian Akhir Semester Genap',
                'slug' => Str::slug('Ujian Akhir Semester Genap'),
                'deskripsi' => 'Pelaksanaan UAS untuk semester genap tahun ajaran 2023/2024',
                'tanggal_mulai' => '2024-05-20 07:00:00',
                'tanggal_selesai' => '2024-05-25 12:00:00',
                'lokasi' => 'Ruang Kelas',
                'penanggung_jawab' => 'Ahmad Rizki, M.Pd.',
                'is_published' => true,
                'status' => true,
            ],
            [
                'judul' => 'Pembagian Rapor Semester Genap',
                'slug' => Str::slug('Pembagian Rapor Semester Genap'),
                'deskripsi' => 'Pengambilan rapor hasil belajar semester genap',
                'tanggal_mulai' => '2024-06-15 08:00:00',
                'tanggal_selesai' => '2024-06-15 12:00:00',
                'lokasi' => 'Ruang Kelas Masing-masing',
                'penanggung_jawab' => 'Siti Nurul, S.Pd.',
                'is_published' => true,
                'status' => true,
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
} 
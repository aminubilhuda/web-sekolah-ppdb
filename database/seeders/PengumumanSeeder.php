<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengumuman = [
            [
                'judul' => 'Pendaftaran PPDB Tahun Ajaran 2024/2025',
                'konten' => 'Diumumkan kepada seluruh calon peserta didik baru bahwa pendaftaran PPDB Tahun Ajaran 2024/2025 akan dibuka pada tanggal 1 Januari 2024. Pendaftaran dapat dilakukan secara online melalui website sekolah atau datang langsung ke sekolah.',
                'tanggal_mulai' => '2024-01-01',
                'tanggal_selesai' => '2024-06-30',
                'tanggal_publish' => now(),
                'is_published' => true,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Jadwal Ujian Semester Ganjil 2023/2024',
                'konten' => 'Berikut adalah jadwal ujian semester ganjil tahun ajaran 2023/2024. Ujian akan dilaksanakan mulai tanggal 4 Desember 2023 sampai dengan 15 Desember 2023. Peserta didik diharapkan mempersiapkan diri dengan baik.',
                'tanggal_mulai' => '2023-12-04',
                'tanggal_selesai' => '2023-12-15',
                'tanggal_publish' => now(),
                'is_published' => true,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Libur Nasional Hari Raya Idul Fitri 2024',
                'konten' => 'Diumumkan bahwa sekolah akan libur pada tanggal 10-12 April 2024 dalam rangka perayaan Hari Raya Idul Fitri 1445 Hijriyah. Kegiatan belajar mengajar akan dimulai kembali pada tanggal 15 April 2024.',
                'tanggal_mulai' => '2024-04-10',
                'tanggal_selesai' => '2024-04-12',
                'tanggal_publish' => now(),
                'is_published' => true,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pembagian Rapor Semester Ganjil 2023/2024',
                'konten' => 'Pembagian rapor semester ganjil tahun ajaran 2023/2024 akan dilaksanakan pada tanggal 22 Desember 2023. Orang tua/wali murid diharapkan hadir untuk mengambil rapor putra/putrinya.',
                'tanggal_mulai' => '2023-12-22',
                'tanggal_selesai' => '2023-12-22',
                'tanggal_publish' => now(),
                'is_published' => true,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Kegiatan Study Tour Kelas XII',
                'konten' => 'Kegiatan study tour untuk siswa kelas XII akan dilaksanakan pada tanggal 15-17 Februari 2024. Tujuan study tour adalah ke beberapa perusahaan teknologi di Jakarta. Pendaftaran dapat dilakukan di ruang BK.',
                'tanggal_mulai' => '2024-02-15',
                'tanggal_selesai' => '2024-02-17',
                'tanggal_publish' => now(),
                'is_published' => true,
                'is_active' => true,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pengumuman')->insert($pengumuman);
    }
} 
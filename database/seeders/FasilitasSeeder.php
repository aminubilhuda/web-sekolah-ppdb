<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FasilitasSeeder extends Seeder
{
    public function run()
    {
        $fasilitas = [
            [
                'nama' => 'Laboratorium Komputer',
                'slug' => 'laboratorium-komputer',
                'deskripsi' => '<p>Laboratorium komputer lengkap dengan 30 unit PC terbaru untuk mendukung pembelajaran TIK, programming, dan multimedia. Dilengkapi dengan proyektor dan whiteboard interaktif untuk presentasi dan pembelajaran yang efektif.</p><p>Fasilitas ini mendukung mata pelajaran seperti Pemrograman Web, Basis Data, Jaringan Komputer, dan Multimedia.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Perpustakaan Digital',
                'slug' => 'perpustakaan-digital',
                'deskripsi' => '<p>Perpustakaan modern dengan koleksi buku fisik dan digital yang lengkap. Dilengkapi dengan ruang baca yang nyaman, akses internet gratis, dan sistem peminjaman otomatis.</p><p>Koleksi mencakup buku pelajaran, referensi, novel, dan e-book yang dapat diakses secara online.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Lapangan Basket',
                'slug' => 'lapangan-basket',
                'deskripsi' => '<p>Lapangan basket outdoor dengan standar internasional untuk kegiatan olahraga dan ekstrakurikuler siswa. Dilengkapi dengan ring basket yang dapat disesuaikan ketinggiannya dan lampu penerangan untuk bermain di malam hari.</p><p>Lapangan ini juga digunakan untuk berbagai event sekolah dan turnamen antar sekolah.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Laboratorium IPA',
                'slug' => 'laboratorium-ipa',
                'deskripsi' => '<p>Laboratorium lengkap untuk praktikum Fisika, Kimia, dan Biologi dengan peralatan modern dan standar keamanan tinggi. Dilengkapi dengan lemari asam, mikroskop digital, dan berbagai alat ukur presisi.</p><p>Setiap siswa mendapatkan meja praktikum yang aman dan nyaman untuk melakukan eksperimen.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Kantin Sekolah',
                'slug' => 'kantin-sekolah',
                'deskripsi' => '<p>Kantin bersih dan sehat dengan berbagai pilihan makanan bergizi untuk siswa dan guru. Menerapkan standar kebersihan yang tinggi dan menyediakan makanan dengan harga terjangkau.</p><p>Tersedia area makan ber-AC yang nyaman dan sistem pembayaran cashless untuk kemudahan transaksi.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Mushola Al-Ikhlas',
                'slug' => 'mushola-al-ikhlas',
                'deskripsi' => '<p>Mushola yang nyaman dan bersih untuk ibadah seluruh warga sekolah. Dilengkapi dengan fasilitas wudhu yang memadai, karpet sajadah berkualitas, dan AC untuk kenyamanan beribadah.</p><p>Tersedia juga mukena dan sarung untuk yang memerlukan, serta jadwal sholat yang selalu diperbarui.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Aula Serbaguna',
                'slug' => 'aula-serbaguna',
                'deskripsi' => '<p>Aula besar yang dapat menampung hingga 500 orang untuk berbagai acara sekolah seperti upacara, seminar, pertunjukan seni, dan rapat besar. Dilengkapi dengan sistem audio visual yang canggih.</p><p>Ruangan ber-AC dengan pencahayaan yang baik dan panggung yang memadai untuk berbagai kegiatan.</p>',
                'image' => null,
                'status' => 'active',
            ],
            [
                'nama' => 'Ruang UKS',
                'slug' => 'ruang-uks',
                'deskripsi' => '<p>Unit Kesehatan Sekolah yang dilengkapi dengan tempat tidur pasien, obat-obatan dasar, dan peralatan P3K lengkap. Dikelola oleh tenaga medis yang kompeten untuk memberikan pelayanan kesehatan kepada siswa dan guru.</p>',
                'image' => null,
                'status' => 'active',
            ]
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::create($item);
        }
    }
} 
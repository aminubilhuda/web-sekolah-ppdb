<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $beritas = [
            [
                'judul' => 'Pembukaan PPDB Tahun Ajaran 2024/2025',
                'konten' => '<h2>Pendaftaran Peserta Didik Baru Resmi Dibuka</h2>
                
                <p><strong>Pendaftaran Peserta Didik Baru (PPDB)</strong> tahun ajaran 2024/2025 akan dibuka pada tanggal <em>1 Juni 2024</em>. Pendaftaran dilakukan secara online melalui website sekolah.</p>
                
                <h3>Syarat Pendaftaran:</h3>
                <ul>
                    <li>Ijazah SMP/sederajat</li>
                    <li>Kartu Keluarga</li>
                    <li>Akta Kelahiran</li>
                    <li>Pas foto 3x4 sebanyak 3 lembar</li>
                </ul>
                
                <blockquote>
                    <p>"Kami mengundang seluruh calon siswa untuk bergabung dengan keluarga besar SMK dan meraih masa depan yang cemerlang bersama kami."</p>
                </blockquote>
                
                <p>Informasi lebih lanjut dapat menghubungi panitia PPDB di nomor <strong>(021) 1234567</strong>.</p>',
                'kategori_id' => 4,
                'image' => 'berita1.jpg',
                'is_published' => true,
                'published_at' => now()
            ],
            [
                'judul' => 'Siswa SMK Juara Lomba Coding Nasional',
                'konten' => '<h2>Prestasi Membanggakan di Ajang Nasional</h2>
                
                <p><strong>Tim coding SMK</strong> berhasil meraih <em>juara 1</em> dalam Lomba Coding Nasional yang diselenggarakan di Jakarta. Prestasi ini membuktikan kualitas pendidikan di bidang teknologi informasi.</p>
                
                <h3>Tim Pemenang:</h3>
                <ul>
                    <li><strong>Ahmad Wijaya</strong> - Ketua Tim</li>
                    <li><strong>Sari Indah</strong> - Frontend Developer</li>
                    <li><strong>Budi Santoso</strong> - Backend Developer</li>
                </ul>
                
                <h3>Teknologi yang Digunakan</h3>
                <p>Tim menggunakan stack teknologi modern:</p>
                <ul>
                    <li>React.js untuk frontend</li>
                    <li>Node.js untuk backend</li>
                    <li>MySQL untuk database</li>
                </ul>
                
                <blockquote>
                    <p>"Ini adalah hasil kerja keras dan dedikasi seluruh tim. Kami bangga bisa mengharumkan nama sekolah di tingkat nasional."</p>
                </blockquote>',
                'kategori_id' => 2,
                'image' => 'berita2.jpg',
                'is_published' => true,
                'published_at' => now()
            ],
            [
                'judul' => 'Kunjungan Industri ke PT. XYZ',
                'konten' => '<h2>Program Pembelajaran di Luar Kelas</h2>
                
                <p>Siswa kelas XI melakukan <strong>kunjungan industri</strong> ke PT. XYZ untuk mempelajari proses produksi dan manajemen perusahaan. Kunjungan ini merupakan bagian dari program pembelajaran di luar kelas.</p>
                
                <h3>Agenda Kunjungan</h3>
                <ol>
                    <li>Presentasi profil perusahaan</li>
                    <li>Tour fasilitas produksi</li>
                    <li>Sesi tanya jawab dengan manajemen</li>
                    <li>Workshop praktik kerja</li>
                </ol>
                
                <h4>Manfaat yang Diperoleh</h4>
                <p>Melalui kunjungan ini, siswa dapat:</p>
                <ul>
                    <li>Memahami dunia kerja yang sesungguhnya</li>
                    <li>Menerapkan teori yang dipelajari di sekolah</li>
                    <li>Membangun networking dengan industri</li>
                </ul>
                
                <blockquote>
                    <p>"Program kunjungan industri sangat bermanfaat untuk mempersiapkan siswa menghadapi dunia kerja yang nyata."</p>
                </blockquote>',
                'kategori_id' => 3,
                'image' => 'berita3.jpg',
                'is_published' => true,
                'published_at' => now()
            ]
        ];

        foreach ($beritas as $berita) {
            Berita::create([
                'judul' => $berita['judul'],
                'slug' => Str::slug($berita['judul']),
                'konten' => $berita['konten'],
                'kategori_id' => $berita['kategori_id'],
                'image' => $berita['image'],
                'is_published' => $berita['is_published'],
                'published_at' => $berita['published_at']
            ]);
        }
    }
} 
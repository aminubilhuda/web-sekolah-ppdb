@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('meta_description', 'Kebijakan Privasi Website PPDB Sekolah')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Kebijakan Privasi</h1>
            
            <div class="prose max-w-none">
                <p class="mb-4">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">1. Pendahuluan</h2>
                <p class="mb-4">
                    Website PPDB Sekolah menghargai privasi pengguna kami. Kebijakan privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi yang Anda berikan saat menggunakan website kami.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">2. Informasi yang Kami Kumpulkan</h2>
                <p class="mb-4">Kami mengumpulkan beberapa jenis informasi, termasuk:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Informasi yang Anda berikan saat mendaftar (nama, email, nomor telepon)</li>
                    <li>Informasi yang diperlukan untuk proses PPDB</li>
                    <li>Data penggunaan website</li>
                    <li>Informasi perangkat dan browser</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">3. Penggunaan Informasi</h2>
                <p class="mb-4">Kami menggunakan informasi yang dikumpulkan untuk:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Memproses pendaftaran PPDB</li>
                    <li>Mengirim informasi penting terkait pendaftaran</li>
                    <li>Meningkatkan layanan website</li>
                    <li>Mengirim notifikasi penting</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">4. Cookie dan Teknologi Pelacakan</h2>
                <p class="mb-4">
                    Website kami menggunakan cookie dan teknologi pelacakan serupa untuk meningkatkan pengalaman pengguna dan menganalisis penggunaan website. Cookie adalah file teks kecil yang disimpan di perangkat Anda.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">5. Iklan</h2>
                <p class="mb-4">
                    Kami menggunakan Google AdSense untuk menampilkan iklan. Google AdSense menggunakan cookie untuk menampilkan iklan berdasarkan kunjungan Anda ke website ini dan website lainnya. Anda dapat memilih untuk tidak menggunakan cookie dengan mengatur preferensi browser Anda.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">6. Keamanan Data</h2>
                <p class="mb-4">
                    Kami menerapkan langkah-langkah keamanan yang wajar untuk melindungi informasi pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">7. Hak Pengguna</h2>
                <p class="mb-4">Anda memiliki hak untuk:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Mengakses data pribadi Anda</li>
                    <li>Memperbarui atau memperbaiki data Anda</li>
                    <li>Meminta penghapusan data Anda</li>
                    <li>Menolak penggunaan data Anda untuk tujuan tertentu</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">8. Perubahan Kebijakan Privasi</h2>
                <p class="mb-4">
                    Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Perubahan akan diposting di halaman ini dengan tanggal pembaruan terakhir.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">9. Hubungi Kami</h2>
                <p class="mb-4">
                    Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami melalui:
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Email: {{ $profil ? $profil->email : 'admin@sekolah.sch.id' }}</li>
                    <li>Telepon: {{ $profil ? $profil->no_hp : '021-XXXXXXXX' }}</li>
                    <li>Alamat: {{ $profil ? $profil->alamat : 'Alamat Sekolah' }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
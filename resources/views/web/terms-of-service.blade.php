@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan')

@section('meta_description', 'Syarat dan Ketentuan Penggunaan Website PPDB Sekolah')

@section('content')
<div class="bg-white py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">Syarat dan Ketentuan</h1>
            
            <div class="prose max-w-none">
                <p class="mb-4">Terakhir diperbarui: {{ date('d F Y') }}</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">1. Penerimaan Syarat dan Ketentuan</h2>
                <p class="mb-4">
                    Dengan mengakses dan menggunakan website PPDB Sekolah ini, Anda menyetujui untuk terikat dengan syarat dan ketentuan ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, mohon untuk tidak menggunakan website ini.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">2. Penggunaan Website</h2>
                <p class="mb-4">Anda setuju untuk:</p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Memberikan informasi yang akurat dan lengkap saat mendaftar</li>
                    <li>Menjaga kerahasiaan akun Anda</li>
                    <li>Menggunakan website sesuai dengan tujuan yang dimaksudkan</li>
                    <li>Tidak melakukan tindakan yang dapat merusak atau mengganggu website</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">3. Proses PPDB</h2>
                <p class="mb-4">
                    Proses PPDB mengikuti ketentuan yang telah ditetapkan oleh sekolah dan pemerintah. Setiap pendaftar wajib memenuhi persyaratan yang ditentukan dan mengikuti prosedur yang berlaku.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">4. Hak Kekayaan Intelektual</h2>
                <p class="mb-4">
                    Semua konten yang ada di website ini, termasuk teks, gambar, logo, dan desain, dilindungi oleh hak cipta dan hak kekayaan intelektual lainnya. Penggunaan konten tanpa izin tertulis dilarang.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">5. Iklan</h2>
                <p class="mb-4">
                    Website ini menampilkan iklan dari Google AdSense. Iklan yang ditampilkan dapat berubah sewaktu-waktu dan tidak mencerminkan pandangan atau rekomendasi dari sekolah.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">6. Pembatasan Tanggung Jawab</h2>
                <p class="mb-4">
                    Sekolah tidak bertanggung jawab atas:
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Kerugian yang timbul dari penggunaan website</li>
                    <li>Konten yang tidak akurat atau tidak lengkap</li>
                    <li>Masalah teknis yang mungkin terjadi</li>
                    <li>Kegagalan dalam proses pendaftaran karena faktor teknis</li>
                </ul>

                <h2 class="text-2xl font-semibold mt-8 mb-4">7. Perubahan Syarat dan Ketentuan</h2>
                <p class="mb-4">
                    Kami berhak untuk mengubah syarat dan ketentuan ini kapan saja. Perubahan akan diposting di halaman ini dengan tanggal pembaruan terakhir.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">8. Hukum yang Berlaku</h2>
                <p class="mb-4">
                    Syarat dan ketentuan ini tunduk pada hukum Republik Indonesia. Setiap perselisihan akan diselesaikan melalui musyawarah atau melalui pengadilan yang berwenang.
                </p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">9. Hubungi Kami</h2>
                <p class="mb-4">
                    Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami melalui:
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
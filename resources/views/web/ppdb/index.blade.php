@extends('layouts.app')

@section('title', 'PPDB')
@section('meta_description', 'Informasi Penerimaan Peserta Didik Baru (PPDB)')

@section('content')
<div class="container mx-auto px-4 py-8">
   
    <!-- Hero Section -->
    <div class="relative bg-primary-600 rounded-lg overflow-hidden mb-8">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ Storage::url($ppdbInfo->gambar_background) }}" alt="PPDB Background">
            <div class="absolute inset-0 bg-primary-600 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ $ppdbInfo->judul }}</h1>
            <p class="mt-6 text-xl text-primary-100 max-w-3xl">{{ $ppdbInfo->subtitle }}</p>
            <div class="mt-8">
                <a href="{{ route('web.ppdb.form') }}" class="inline-block bg-white text-primary-600 px-8 py-3 rounded-md font-medium hover:bg-primary-50">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi Section -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi PPDB</h2>
            <div class="prose max-w-none">
                <p>Penerimaan Peserta Didik Baru (PPDB) tahun ajaran 2024/2025 akan segera dibuka. Berikut adalah informasi penting yang perlu diketahui:</p>
                
                <h3>Persyaratan Umum:</h3>
                <ul>
                    @php
                        $persyaratan = is_string($ppdbInfo->persyaratan) ? json_decode($ppdbInfo->persyaratan, true) : $ppdbInfo->persyaratan;
                    @endphp
                    @if(is_array($persyaratan))
                        @foreach($persyaratan as $item)
                            @if(is_array($item) && isset($item['item']))
                                <li>{{ $item['item'] }}</li>
                            @elseif(is_string($item))
                                <li>{{ $item }}</li>
                            @endif
                        @endforeach
                    @endif
                </ul>

                <h3>Jadwal Penting:</h3>
                <ul>
                    @php
                        $jadwal = is_string($ppdbInfo->jadwal) ? json_decode($ppdbInfo->jadwal, true) : $ppdbInfo->jadwal;
                    @endphp
                    @if(is_array($jadwal))
                        @foreach($jadwal as $item)
                            <li>
                                {{ $item['kegiatan'] }}: 
                                {{ \Carbon\Carbon::parse($item['tanggal_mulai'])->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($item['tanggal_selesai'])->format('d M Y') }}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <!-- Jurusan Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Jurusan yang Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($jurusans as $item)
                <div class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $item->nama }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <p class="text-sm text-gray-500">Kuota: {{ $item->kuota_ppdb }} siswa</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Panduan Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Panduan Pendaftaran</h2>
            <div class="prose max-w-none">
                <p>Untuk memudahkan proses pendaftaran, silakan ikuti langkah-langkah berikut:</p>
                <ol>
                    <li>Persiapkan dokumen yang diperlukan:
                        <ul>
                            <li>Ijazah/SKL SMP/MTs</li>
                            <li>SKHUN</li>
                            <li>Kartu Keluarga</li>
                            <li>Akta Kelahiran</li>
                            <li>Pas Foto 3x4 (2 lembar)</li>
                        </ul>
                    </li>
                    <li>Klik tombol "Daftar Sekarang" di atas</li>
                    <li>Isi formulir pendaftaran dengan lengkap</li>
                    <li>Upload dokumen yang diperlukan</li>
                    <li>Simpan nomor pendaftaran yang diberikan</li>
                    <li>Tunggu pengumuman hasil seleksi</li>
                </ol>
                <p>Untuk informasi lebih lanjut, silakan hubungi panitia PPDB di:</p>
                <ul>
                    <li>Telepon: {{ $ppdbInfo->telepon }}</li>
                    <li>WhatsApp: {{ $ppdbInfo->whatsapp }}</li>
                    <li>Email: {{ $ppdbInfo->email }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
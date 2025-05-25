@extends('layouts.app')

@section('title', $alumni->nama)
@section('meta_description', 'Profil detail alumni ' . $alumni->nama)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($alumni->foto ?? 'images/default-avatar.png') }}" alt="{{ $alumni->nama }}" 
                    class="w-full h-64 object-cover">
                <div class="absolute top-4 right-4 flex gap-2">
                    @if($alumni->status_bekerja)
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                        Bekerja
                    </span>
                    @endif
                    @if($alumni->status_kuliah)
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                        Kuliah
                    </span>
                    @endif
                </div>
            </div>
            
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $alumni->nama }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Data Pribadi -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Data Pribadi</h2>
                        <div class="space-y-3 text-gray-600">
                            <p><span class="font-medium">NIS:</span> {{ $alumni->nis ?? '-' }}</p>
                            <p><span class="font-medium">NISN:</span> {{ $alumni->nisn ?? '-' }}</p>
                            <p><span class="font-medium">Jenis Kelamin:</span> {{ $alumni->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            <p><span class="font-medium">Tempat Lahir:</span> {{ $alumni->tempat_lahir ?? '-' }}</p>
                            <p><span class="font-medium">Tanggal Lahir:</span> {{ $alumni->tanggal_lahir ? $alumni->tanggal_lahir->format('d F Y') : '-' }}</p>
                            <p><span class="font-medium">Agama:</span> {{ $alumni->agama ?? '-' }}</p>
                            <p><span class="font-medium">Alamat:</span> {{ $alumni->alamat ?? '-' }}</p>
                            <p><span class="font-medium">No. HP:</span> {{ $alumni->no_hp ?? '-' }}</p>
                            <p><span class="font-medium">Email:</span> {{ $alumni->email ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Data Akademik -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Data Akademik</h2>
                        <div class="space-y-3 text-gray-600">
                            <p><span class="font-medium">Jurusan:</span> {{ $alumni->jurusan->nama_jurusan }}</p>
                            <p><span class="font-medium">Tahun Lulus:</span> {{ $alumni->tahun_lulus }}</p>
                        </div>

                        @if($alumni->status_bekerja)
                        <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">Data Pekerjaan</h2>
                        <div class="space-y-3 text-gray-600">
                            <p><span class="font-medium">Perusahaan:</span> {{ $alumni->nama_perusahaan }}</p>
                            <p><span class="font-medium">Jabatan:</span> {{ $alumni->jabatan }}</p>
                            <p><span class="font-medium">Alamat:</span> {{ $alumni->alamat_perusahaan }}</p>
                        </div>
                        @endif

                        @if($alumni->status_kuliah)
                        <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">Data Kuliah</h2>
                        <div class="space-y-3 text-gray-600">
                            <p><span class="font-medium">Kampus:</span> {{ $alumni->nama_kampus }}</p>
                            <p><span class="font-medium">Jurusan:</span> {{ $alumni->jurusan_kuliah }}</p>
                            <p><span class="font-medium">Tahun Masuk:</span> {{ $alumni->tahun_masuk }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($alumni->testimoni)
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Testimoni</h2>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="text-gray-700 italic">"{{ $alumni->testimoni }}"</p>
                    </div>
                </div>
                @endif

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('web.alumni.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        ← Kembali ke daftar alumni
                    </a>
                    <div class="flex gap-4">
                        @if($alumni->status_bekerja)
                        <a href="{{ route('web.alumni.bekerja') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Lihat alumni bekerja →
                        </a>
                        @endif
                        @if($alumni->status_kuliah)
                        <a href="{{ route('web.alumni.kuliah') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Lihat alumni kuliah →
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
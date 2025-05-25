@extends('layouts.app')

@section('title', 'Alumni')
@section('meta_description', 'Profil dan prestasi alumni sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Alumni</h1>

    <!-- Search Form -->
    <div class="mb-8">
        <form action="{{ route('web.alumni.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="Cari nama, NIS, atau NISN...">
            </div>
            <div class="flex gap-4">
                <select name="jurusan" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                    <option value="{{ $j->id }}" {{ request('jurusan') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }}
                    </option>
                    @endforeach
                </select>
                <select name="tahun_lulus" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Semua Tahun</option>
                    @foreach($tahun_lulus as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($alumni as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($item->foto ?? 'images/default-avatar.png') }}" alt="{{ $item->nama }}" 
                    class="w-full h-48 object-cover">
                @if($item->status_bekerja)
                <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                    Bekerja
                </span>
                @endif
                @if($item->status_kuliah)
                <span class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                    Kuliah
                </span>
                @endif
            </div>
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.alumni.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama }}
                    </a>
                </h2>
                <div class="text-sm text-gray-500 mb-4">
                    <p>NIS: {{ $item->nis ?? '-' }}</p>
                    <p>NISN: {{ $item->nisn ?? '-' }}</p>
                    <p>Lulus: {{ $item->tahun_lulus }}</p>
                    <p>Jurusan: {{ $item->jurusan->nama_jurusan }}</p>
                    @if($item->status_bekerja)
                    <div class="mt-2">
                        <p class="font-medium">Data Pekerjaan:</p>
                        <p>Perusahaan: {{ $item->nama_perusahaan }}</p>
                        <p>Jabatan: {{ $item->jabatan }}</p>
                    </div>
                    @endif
                    @if($item->status_kuliah)
                    <div class="mt-2">
                        <p class="font-medium">Data Kuliah:</p>
                        <p>Kampus: {{ $item->nama_kampus }}</p>
                        <p>Jurusan: {{ $item->jurusan_kuliah }}</p>
                        <p>Tahun Masuk: {{ $item->tahun_masuk }}</p>
                    </div>
                    @endif
                </div>
                <a href="{{ route('web.alumni.show', $item->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Lihat profil →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada data alumni yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $alumni->links() }}
    </div>
</div>
@endsection 
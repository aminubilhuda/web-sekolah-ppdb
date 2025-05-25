@extends('layouts.app')

@section('title', 'Alumni')
@section('meta_description', 'Profil dan prestasi alumni sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Alumni</h1>

    <!-- Search Form -->
    <div class="mb-8">
        <form action="{{ route('web.alumni.index') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    placeholder="Cari nama atau tahun lulus...">
            </div>
            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">
                Cari
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($alumni as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.alumni.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama }}
                    </a>
                </h2>
                <div class="text-sm text-gray-500 mb-4">
                    <p>Lulus: {{ $item->tahun_lulus }}</p>
                    <p>Jurusan: {{ $item->jurusan->nama_jurusan }}</p>
                    @if($item->tempat_kerja)
                    <p>Tempat Kerja: {{ $item->tempat_kerja }}</p>
                    @endif
                    @if($item->jabatan)
                    <p>Jabatan: {{ $item->jabatan }}</p>
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
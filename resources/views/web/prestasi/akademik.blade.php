@extends('layouts.app')

@section('title', 'Prestasi Akademik')
@section('meta_description', 'Prestasi-prestasi akademik yang telah diraih oleh siswa dan sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Prestasi Akademik</h1>

    <!-- Filter Kategori -->
    <div class="mb-8">
        <div class="flex space-x-4">
            <a href="{{ route('web.prestasi.index') }}" 
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Semua
            </a>
            <a href="{{ route('web.prestasi.akademik') }}" 
               class="px-4 py-2 rounded-lg bg-primary-600 text-white">
                Akademik
            </a>
            <a href="{{ route('web.prestasi.non-akademik') }}" 
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Non-Akademik
            </a>
        </div>
    </div>

    <!-- Daftar Prestasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($prestasis as $prestasi)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($prestasi->gambar)
            <img src="{{ asset($prestasi->gambar) }}" alt="{{ $prestasi->judul }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>{{ $prestasi->kategori->nama }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $prestasi->tanggal->format('d M Y') }}</span>
                </div>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.prestasi.show', $prestasi->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $prestasi->judul }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($prestasi->deskripsi, 150) }}</p>
                <a href="{{ route('web.prestasi.show', $prestasi->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Baca selengkapnya →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada prestasi akademik yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $prestasis->links() }}
    </div>
</div>
@endsection 
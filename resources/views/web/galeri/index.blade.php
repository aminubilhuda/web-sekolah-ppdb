@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_description', 'Galeri foto dan video kegiatan sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Galeri</h1>

    <!-- Filter -->
    <div class="mb-8">
        <div class="flex space-x-4">
            <a href="{{ route('web.galeri.index') }}" 
               class="px-4 py-2 rounded-lg {{ request()->routeIs('web.galeri.index') ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua
            </a>
            <a href="{{ route('web.galeri.foto') }}" 
               class="px-4 py-2 rounded-lg {{ request()->routeIs('web.galeri.foto') ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Foto
            </a>
            <a href="{{ route('web.galeri.video') }}" 
               class="px-4 py-2 rounded-lg {{ request()->routeIs('web.galeri.video') ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Video
            </a>
        </div>
    </div>

    <!-- Grid Galeri -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($galeris as $galeri)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($galeri->tipe === 'foto')
                <img src="{{ asset($galeri->file) }}" alt="{{ $galeri->judul }}" class="w-full h-48 object-cover">
            @else
                <div class="relative pb-[56.25%]">
                    <iframe src="{{ $galeri->file }}" 
                            class="absolute top-0 left-0 w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            @endif
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>{{ ucfirst($galeri->tipe) }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $galeri->tanggal->format('d M Y') }}</span>
                </div>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.galeri.show', $galeri->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $galeri->judul }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($galeri->deskripsi, 150) }}</p>
                <a href="{{ route('web.galeri.show', $galeri->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Lihat selengkapnya →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada galeri yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $galeris->links() }}
    </div>
</div>
@endsection 
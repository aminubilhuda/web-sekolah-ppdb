@php
    function getYoutubeId($url) {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return $url;
    }
@endphp

@extends('layouts.app')

@section('title', 'Galeri - ' . config('app.name'))
@section('meta_description', 'Galeri foto dan video kegiatan sekolah')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<style>
    .gallery-container {
        columns: 1 250px;
        column-gap: 1.5rem;
        padding: 1.5rem;
    }

    .gallery-item {
        break-inside: avoid;
        margin-bottom: 1.5rem;
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        background: white;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .gallery-item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
        cursor: pointer;
    }

    .gallery-item video {
        width: 100%;
        height: auto;
        display: block;
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7));
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        color: white;
        transform: translateY(100%);
        transition: transform 0.3s ease;
        pointer-events: none;
    }

    .gallery-item:hover .gallery-content {
        transform: translateY(0);
    }

    .gallery-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 2;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        pointer-events: none;
    }

    .gallery-item:hover .gallery-badge {
        opacity: 1;
        transform: translateY(0);
    }

    .gallery-photo-count {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        pointer-events: none;
    }

    .gallery-item:hover .gallery-photo-count {
        opacity: 1;
        transform: translateY(0);
    }

    .gallery-photos {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.25rem;
        position: relative;
        z-index: 1;
    }

    .gallery-photos a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .gallery-photos img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .gallery-photos a:first-child {
        grid-column: span 2;
        grid-row: span 2;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    .filter-button {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        z-index: 1;
    }

    .filter-button.active {
        background-color: #4F46E5 !important;
        color: white !important;
    }

    @media (min-width: 640px) {
        .gallery-container {
            columns: 2 250px;
        }
    }

    @media (min-width: 1024px) {
        .gallery-container {
            columns: 3 250px;
        }
    }

    @media (min-width: 1280px) {
        .gallery-container {
            columns: 4 250px;
        }
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-b from-primary-50 to-white min-h-screen">
    <div class="container py-12">
        <!-- Header Section -->
        <div class="text-center mb-12 animate-fade-in" style="animation-delay: 0.1s">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Galeri</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Dokumentasi kegiatan dan fasilitas sekolah kami
            </p>
        </div>

        <!-- Filter Section -->
        <div class="max-w-7xl mx-auto mb-8 animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex justify-center space-x-4">
                <button type="button" class="filter-button px-6 py-3 rounded-full bg-primary-600 text-white font-medium transition-all duration-300 hover:bg-primary-700 active" data-filter="all">
                    Semua
                </button>
                <button type="button" class="filter-button px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-medium transition-all duration-300 hover:bg-gray-300" data-filter="foto">
                    Foto
                </button>
                <button type="button" class="filter-button px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-medium transition-all duration-300 hover:bg-gray-300" data-filter="video">
                    Video
                </button>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="max-w-7xl mx-auto">
            <div class="gallery-container">
                @forelse($galeri as $index => $item)
                    <div class="gallery-item animate-fade-in" 
                         data-type="{{ $item->jenis }}"
                         style="animation-delay: {{ $index * 0.1 }}s">
                        @if($item->jenis === 'foto')
                            @if($item->foto && $item->foto->count() > 0)
                                <div class="gallery-photos">
                                    @foreach($item->foto->take(4) as $index => $foto)
                                        <a href="{{ $foto->gambar_url }}" 
                                           data-lightbox="gallery-{{ $item->id }}"
                                           data-title="{{ $item->judul }}"
                                           class="gallery-link">
                                            <img src="{{ $foto->gambar_url }}" 
                                                 alt="{{ $item->judul }}"
                                                 loading="lazy">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{ $item->gambar_url }}" 
                                   data-lightbox="gallery-{{ $item->id }}"
                                   data-title="{{ $item->judul }}"
                                   class="gallery-link">
                                    <img src="{{ $item->gambar_url }}" 
                                         alt="{{ $item->judul }}"
                                         loading="lazy">
                                </a>
                            @endif
                        @else
                            <div class="relative">
                                <iframe 
                                    src="https://www.youtube.com/embed/{{ getYoutubeId($item->url_video) }}?enablejsapi=1&origin={{ urlencode(config('app.url')) }}&rel=0&modestbranding=1" 
                                    class="w-full aspect-video"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @endif
                        
                        <div class="gallery-overlay"></div>
                        
                        @if($item->jenis === 'foto' && $item->foto && $item->foto->count() > 0)
                            <span class="gallery-photo-count">
                                {{ $item->foto->count() }} Foto
                            </span>
                        @endif
                        
                        <span class="gallery-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->jenis === 'foto' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->jenis === 'foto' ? 'Foto' : 'Video' }}
                        </span>

                        <div class="gallery-content">
                            <h3 class="text-xl font-semibold mb-2">{{ $item->judul }}</h3>
                            <p class="text-sm text-gray-200 mb-2">{{ Str::limit($item->deskripsi, 100) }}</p>
                            <span class="text-xs text-gray-300">{{ $item->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 animate-fade-in">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada galeri</h3>
                        <p class="mt-1 text-sm text-gray-500">Galeri sedang dalam proses pengisian.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="max-w-7xl mx-auto mt-8">
            {{ $galeri->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    $(document).ready(function() {
        // Lightbox options
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': "Foto %1 dari %2"
        });

        // Filter functionality
        $('.filter-button').on('click', function() {
            const filter = $(this).data('filter');
            
            // Update active button
            $('.filter-button').removeClass('active bg-primary-600 text-white').addClass('bg-gray-200 text-gray-700');
            $(this).addClass('active bg-primary-600 text-white').removeClass('bg-gray-200 text-gray-700');
            
            // Filter items
            $('.gallery-item').each(function(index) {
                const item = $(this);
                if (filter === 'all' || item.data('type') === filter) {
                    item.show();
                    item.css('animation', `fadeIn 0.5s ease forwards ${index * 0.1}s`);
                } else {
                    item.hide();
                }
            });
        });

        // Initialize with 'all' filter
        $('.filter-button[data-filter="all"]').trigger('click');
    });
</script>
@endpush
@endsection 
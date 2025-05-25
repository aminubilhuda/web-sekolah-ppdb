@extends('layouts.app')

@section('title', $berita->judul)
@section('meta_description', Str::limit(strip_tags($berita->konten), 160))

@section('content')
    <!-- Hero Section with Parallax -->
    <div class="relative h-[60vh] overflow-hidden">
        <div class="absolute inset-0">
            @if($berita->image)
                <img class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700" 
                    src="{{ asset('storage/' . $berita->image) }}" 
                    alt="{{ $berita->judul }}">
            @else
                <div class="w-full h-full bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-center">
                    <span class="text-white text-xl font-medium">Tidak ada gambar</span>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        </div>
        
        <!-- Content Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center text-sm text-white/90 mb-4 space-x-4">
                    <span class="bg-blue-600/80 px-3 py-1 rounded-full text-sm">
                        {{ $berita->kategori->nama }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $berita->created_at->format('d M Y') }}
                    </span>
                    @if($berita->published_at)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $berita->published_at->format('d M Y H:i') }}
                        </span>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    {{ $berita->judul }}
                </h1>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-sm p-8 transform hover:shadow-lg transition-shadow duration-300">
                        <div class="prose prose-lg max-w-none">
                            {!! $berita->konten !!}
                        </div>

                        <!-- Share Buttons -->
                        <div class="mt-12 pt-8 border-t border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Berita</h3>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                    target="_blank" 
                                    class="bg-blue-600 text-white p-3 rounded-full hover:bg-blue-700 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                                    target="_blank"
                                    class="bg-sky-500 text-white p-3 rounded-full hover:bg-sky-600 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                    </svg>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                                    target="_blank"
                                    class="bg-green-500 text-white p-3 rounded-full hover:bg-green-600 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="mt-12 lg:mt-0 lg:col-span-4">
                    <!-- Related News -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 transform hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Berita Terbaru
                        </h3>
                        <div class="space-y-6">
                            @foreach($beritaTerbaru as $terbaru)
                            <div class="flex space-x-4 group">
                                @if($terbaru->image)
                                    <img src="{{ asset('storage/' . $terbaru->image) }}" 
                                        alt="{{ $terbaru->judul }}" 
                                        class="h-20 w-20 object-cover rounded-xl transform group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="h-20 w-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                        <span class="text-white text-xs">No Image</span>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors duration-300">
                                        <a href="{{ route('web.berita.show', $terbaru->slug) }}">
                                            {{ $terbaru->judul }}
                                        </a>
                                    </h4>
                                    <p class="mt-1 text-sm text-gray-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $terbaru->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mt-8 bg-white rounded-2xl shadow-sm p-6 transform hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Kategori
                        </h3>
                        <div class="space-y-3">
                            @foreach($kategoris as $kategori)
                            <a href="{{ route('web.berita.index', ['kategori' => $kategori->id]) }}" 
                                class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition-colors duration-300 group">
                                <span class="font-medium">{{ $kategori->nama }}</span>
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs font-medium group-hover:bg-blue-200 transition-colors duration-300">
                                    {{ $kategori->berita_count }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Animasi scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.transform');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                }
            });
        });

        elements.forEach(element => {
            element.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-1000');
            observer.observe(element);
        });
    });
</script>
@endpush 
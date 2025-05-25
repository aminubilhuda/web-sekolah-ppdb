@extends('layouts.app')

@section('title', $prestasi->judul)
@section('meta_description', Str::limit($prestasi->deskripsi, 160))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('web.home') }}" class="text-gray-700 hover:text-primary-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="{{ route('web.prestasi.index') }}" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2">Prestasi</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-gray-500 md:ml-2">{{ $prestasi->judul }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Content -->
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($prestasi->gambar)
            <img src="{{ asset($prestasi->gambar) }}" alt="{{ $prestasi->judul }}" class="w-full h-96 object-cover">
            @endif
            <div class="p-8">
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>{{ $prestasi->kategori->nama }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $prestasi->tanggal->format('d M Y') }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $prestasi->judul }}</h1>
                <div class="prose max-w-none">
                    {!! $prestasi->deskripsi !!}
                </div>
            </div>
        </article>

        <!-- Related Prestasi -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Prestasi Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($prestasi->kategori->prestasi()->where('id', '!=', $prestasi->id)->take(3)->get() as $related)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($related->gambar)
                    <img src="{{ asset($related->gambar) }}" alt="{{ $related->judul }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('web.prestasi.show', $related->id) }}" class="text-gray-900 hover:text-primary-600">
                                {{ $related->judul }}
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($related->deskripsi, 100) }}</p>
                        <a href="{{ route('web.prestasi.show', $related->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Baca selengkapnya →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('title', 'Berita')
@section('meta_description', 'Berita terbaru seputar kegiatan dan informasi sekolah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Berita Terbaru</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($berita as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->judul }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Tidak ada gambar</span>
                </div>
            @endif
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <span>{{ $item->kategori->nama }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $item->created_at->format('d M Y') }}</span>
                </div>
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.berita.show', $item->slug) }}" class="text-gray-900 hover:text-blue-600">
                        {{ $item->judul }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($item->konten), 150) }}</p>
                <a href="{{ route('web.berita.show', $item->slug) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Baca selengkapnya →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada berita yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $berita->links() }}
    </div>
</div>
@endsection 
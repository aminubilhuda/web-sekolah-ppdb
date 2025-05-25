@extends('layouts.app')

@section('title', 'Ekstrakurikuler')
@section('meta_description', 'Informasi tentang kegiatan ekstrakurikuler yang tersedia di sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Ekstrakurikuler</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($ekstrakurikulers as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($item->gambar)
                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->nama_ekstrakurikuler }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Tidak ada gambar</span>
                </div>
            @endif
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.ekstrakurikuler.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama_ekstrakurikuler }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($item->deskripsi, 150) }}</p>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>Pembina: {{ $item->pembina }}</span>
                </div>
                <a href="{{ route('web.ekstrakurikuler.show', $item->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Pelajari lebih lanjut →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada ekstrakurikuler yang ditambahkan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection 
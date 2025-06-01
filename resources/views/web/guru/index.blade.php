@extends('layouts.app')

@section('title', 'Guru')
@section('meta_description', 'Profil guru-guru di sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Guru</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($gurus as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($item->foto)
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            @endif
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.guru.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama }}
                    </a>
                </h2>
                <div class="text-sm text-gray-500 mb-4">
                    @if($item->nip)
                        <p>NIP: {{ $item->nip }}</p>
                    @endif
                    <p>Jabatan: {{ $item->jabatan }}</p>
                    <p>Bidang Studi: {{ $item->bidang_studi }}</p>
                </div>
                @if($item->deskripsi)
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->deskripsi, 100) }}</p>
                @endif
                <a href="{{ route('web.guru.show', $item->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                    Lihat profil →
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada data guru yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $gurus->links() }}
    </div>
</div>
@endsection 
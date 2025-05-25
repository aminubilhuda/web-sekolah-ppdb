@extends('layouts.app')

@section('title', 'Guru')
@section('meta_description', 'Profil guru-guru di sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Guru</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($gurus as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" class="w-full h-48 object-cover">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.guru.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama }}
                    </a>
                </h2>
                <div class="text-sm text-gray-500 mb-4">
                    <p>NIP: {{ $item->nip }}</p>
                    <p>Bidang: {{ $item->bidang }}</p>
                    <p>Pendidikan: {{ $item->pendidikan }}</p>
                </div>
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
@extends('layouts.app')

@section('title', 'Testimoni Alumni')
@section('meta_description', 'Testimoni dan pengalaman alumni sekolah kami')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Testimoni Alumni</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($testimoni as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($item->foto ?? 'images/default-avatar.png') }}" alt="{{ $item->nama }}" 
                    class="w-full h-48 object-cover">
                @if($item->status_bekerja)
                <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                    Bekerja
                </span>
                @endif
                @if($item->status_kuliah)
                <span class="absolute top-2 left-2 bg-blue-500 text-white px-2 py-1 rounded-full text-xs">
                    Kuliah
                </span>
                @endif
            </div>
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.alumni.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama }}
                    </a>
                </h2>
                <div class="text-sm text-gray-500 mb-4">
                    <p>Lulus: {{ $item->tahun_lulus }}</p>
                    <p>Jurusan: {{ $item->jurusan->nama_jurusan }}</p>
                </div>
                <div class="mt-4 text-gray-700 italic">
                    "{{ $item->testimoni }}"
                </div>
                <div class="mt-4">
                    <a href="{{ route('web.alumni.show', $item->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        Lihat profil →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada testimoni yang ditambahkan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $testimoni->links() }}
    </div>
</div>
@endsection 
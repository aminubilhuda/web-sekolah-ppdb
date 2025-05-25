@extends('layouts.app')

@section('title', 'Alumni Bekerja')
@section('meta_description', 'Profil alumni yang telah bekerja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Alumni Bekerja</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($bekerja as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($item->foto ?? 'images/default-avatar.png') }}" alt="{{ $item->nama }}" 
                    class="w-full h-48 object-cover">
                <span class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                    Bekerja
                </span>
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
                <div class="mt-4">
                    <h3 class="font-medium text-gray-900">Data Pekerjaan:</h3>
                    <div class="mt-2 text-gray-600">
                        <p><span class="font-medium">Perusahaan:</span> {{ $item->nama_perusahaan }}</p>
                        <p><span class="font-medium">Jabatan:</span> {{ $item->jabatan }}</p>
                        <p><span class="font-medium">Alamat:</span> {{ $item->alamat_perusahaan }}</p>
                    </div>
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
            <p class="text-gray-500">Belum ada data alumni yang bekerja.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $bekerja->links() }}
    </div>
</div>
@endsection 
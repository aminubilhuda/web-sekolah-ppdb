@extends('layouts.app')

@section('title', 'Agenda')
@section('meta_description', 'Agenda kegiatan sekolah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Agenda Kegiatan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($agendas as $agenda)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $agenda->judul }}</h2>
                    <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($agenda->deskripsi), 100) }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Mulai: {{ $agenda->tanggal_mulai ? \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d M Y H:i') : '-' }}
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Selesai: {{ $agenda->tanggal_selesai ? \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('d M Y H:i') : '-' }}
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $agenda->lokasi }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('web.agenda.show', $agenda->slug) }}" class="text-blue-600 hover:text-blue-800">Baca selengkapnya →</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-8">
                <p class="text-gray-500">Belum ada agenda kegiatan</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $agendas->links() }}
    </div>
</div>
@endsection 
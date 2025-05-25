@extends('layouts.app')

@section('title', $agenda->judul)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($agenda->deskripsi), 160))

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-blue-800 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-white mb-4">{{ $agenda->judul }}</h1>
            <div class="flex justify-center space-x-4 text-white/80">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $agenda->tanggal_mulai ? \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d M Y H:i') : '-' }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $agenda->lokasi }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">Informasi Waktu</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Tanggal Mulai</p>
                                    <p class="font-medium">{{ $agenda->tanggal_mulai ? \Carbon\Carbon::parse($agenda->tanggal_mulai)->format('d M Y H:i') : '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Tanggal Selesai</p>
                                    <p class="font-medium">{{ $agenda->tanggal_selesai ? \Carbon\Carbon::parse($agenda->tanggal_selesai)->format('d M Y H:i') : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4">Informasi Lokasi</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Lokasi</p>
                                    <p class="font-medium">{{ $agenda->lokasi }}</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Penanggung Jawab</p>
                                    <p class="font-medium">{{ $agenda->penanggung_jawab }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Agenda</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $agenda->deskripsi !!}
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <a href="{{ route('web.agenda.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar Agenda
                    </a>
                    <div class="text-sm text-gray-500">
                        Terakhir diperbarui: {{ $agenda->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
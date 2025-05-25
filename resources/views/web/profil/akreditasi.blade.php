@extends('layouts.app')

@section('title', 'Akreditasi - ' . config('app.name'))

@section('content')
<div class="bg-gradient-to-b from-primary-50 to-white">
    <div class="container py-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Akreditasi Sekolah</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Bukti pengakuan kualitas pendidikan kami dari Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M)
            </p>
        </div>

        <!-- Status Akreditasi Card -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                <div class="p-8">
                    <div class="text-center">
                        <div class="inline-block p-4 rounded-full bg-primary-100 mb-6">
                            <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Status Akreditasi</h2>
                        <div class="inline-block px-8 py-4 rounded-full bg-primary-600 text-white text-5xl font-bold mb-6 transform hover:scale-110 transition-transform duration-300">
                            {{ strtoupper($profil->status_akreditasi ?? '-') }}
                        </div>
                        <p class="text-gray-600">Berdasarkan penilaian Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M)</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Dokumen Akreditasi</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @if($profil && $profil->sk_pendirian)
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900">SK Pendirian</h4>
                                    <a href="{{ asset('storage/' . $profil->sk_pendirian) }}" class="inline-flex items-center mt-2 text-primary-600 hover:text-primary-700" target="_blank">
                                        <span>Lihat Dokumen</span>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($profil && $profil->sk_izin_operasional)
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900">SK Izin Operasional</h4>
                                    <a href="{{ asset('storage/' . $profil->sk_izin_operasional) }}" class="inline-flex items-center mt-2 text-primary-600 hover:text-primary-700" target="_blank">
                                        <span>Lihat Dokumen</span>
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if(!$profil || (!$profil->sk_pendirian && !$profil->sk_izin_operasional))
                    <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Dokumen akreditasi sedang dalam proses pengunggahan
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
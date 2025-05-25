@extends('layouts.app')

@section('title', 'Hubungan Industri - ' . config('app.name'))

@section('content')
<div class="bg-gradient-to-b from-primary-50 to-white">
    <div class="container py-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Hubungan Industri</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Kami menjalin kerjasama strategis dengan berbagai perusahaan terkemuka untuk memberikan pengalaman kerja yang nyata bagi siswa kami
            </p>
        </div>

        <!-- Statistik Section -->
        <div class="max-w-7xl mx-auto mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $mitra_count ?? 0 }}</div>
                    <div class="text-gray-600">Mitra Industri</div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $siswa_magang ?? 0 }}</div>
                    <div class="text-gray-600">Siswa Magang</div>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="text-4xl font-bold text-primary-600 mb-2">{{ $penyerapan ?? 0 }}%</div>
                    <div class="text-gray-600">Tingkat Penyerapan</div>
                </div>
            </div>
        </div>

        <!-- Mitra Section -->
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-8 text-center">Mitra Kerjasama Kami</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($mitra ?? [] as $m)
                        <div class="bg-gradient-to-br from-white to-primary-50 rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center border border-primary-100">
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $m->logo) }}" alt="{{ $m->nama_perusahaan }}" class="w-32 h-32 object-contain">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $m->nama_perusahaan }}</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                {{ $m->jenis_kerjasama }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada mitra</h3>
                                <p class="mt-1 text-sm text-gray-500">Data mitra kerjasama sedang dalam proses pengisian.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Program Kerjasama Section -->
        <div class="max-w-7xl mx-auto mt-12">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-8 text-center">Program Kerjasama</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Praktik Kerja Lapangan</h3>
                                <p class="mt-2 text-gray-600">Program magang untuk siswa kelas XI dan XII di perusahaan mitra selama 3-6 bulan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Penyerapan Lulusan</h3>
                                <p class="mt-2 text-gray-600">Program rekrutmen langsung untuk lulusan yang memenuhi kualifikasi perusahaan mitra.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Pelatihan Bersama</h3>
                                <p class="mt-2 text-gray-600">Program pelatihan dan sertifikasi yang diselenggarakan bersama mitra industri.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Seminar & Workshop</h3>
                                <p class="mt-2 text-gray-600">Program pengembangan kompetensi melalui seminar dan workshop bersama praktisi industri.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
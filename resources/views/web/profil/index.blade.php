@extends('layouts.app')

@section('title', 'Profil Sekolah')
@section('meta_description', 'Profil SMK - Sekolah Menengah Kejuruan terbaik dengan fokus pada pengembangan kompetensi siswa dalam bidang teknologi dan industri.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="relative bg-primary-600 rounded-lg overflow-hidden mb-8">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ $profil && $profil->gedung_image ? asset('storage/' . $profil->gedung_image) : asset('images/school-building.jpg') }}" alt="Gedung Sekolah">
            <div class="absolute inset-0 bg-primary-600 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Profil Sekolah</h1>
            <p class="mt-6 text-xl text-primary-100 max-w-3xl">Membentuk generasi muda yang kompeten dan siap menghadapi tantangan industri di era digital.</p>
        </div>
    </div>

    <!-- Sejarah Section -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Sejarah</h2>
            <div class="prose max-w-none">
                @if($profil && $profil->sejarah)
                    {!! $profil->sejarah !!}
                @else
                    <p class="text-gray-600">Sejarah sekolah sedang dalam proses penyusunan.</p>
                @endif
            </div>
        </div>

        <!-- Visi & Misi Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Visi</h2>
                <div class="prose max-w-none">
                    @if($profil && $profil->visi)
                        <p>{{ $profil->visi }}</p>
                    @else
                        <p class="text-gray-600">Visi sekolah sedang dalam proses penyusunan.</p>
                    @endif
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Misi</h2>
                <div class="prose max-w-none">
                    @if($profil && $profil->misi)
                        {!! $profil->misi !!}
                    @else
                        <p class="text-gray-600">Misi sekolah sedang dalam proses penyusunan.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Program Unggulan Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Program Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Teaching Factory</h3>
                    <p class="text-gray-600">Program pembelajaran yang mengintegrasikan proses produksi industri ke dalam pembelajaran di sekolah.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Program Magang</h3>
                    <p class="text-gray-600">Program magang di industri mitra untuk memberikan pengalaman kerja langsung kepada siswa.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary-100 rounded-full p-4 w-16 h-16 mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Sertifikasi Kompetensi</h3>
                    <p class="text-gray-600">Program sertifikasi kompetensi untuk memastikan siswa memiliki keterampilan yang diakui industri.</p>
                </div>
            </div>
        </div>

        <!-- Fasilitas Section -->
        @if($fasilitas && count($fasilitas) > 0)
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Fasilitas</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($fasilitas as $fasil)
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    <img src="{{ $fasil->image ? asset('storage/' . $fasil->image) : asset('images/default-facility.jpg') }}" alt="{{ $fasil->nama }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold mb-2">{{ $fasil->nama }}</h3>
                        <p class="text-gray-600">{{ $fasil->deskripsi ?? 'Deskripsi fasilitas belum tersedia' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Fasilitas</h2>
            <div class="text-center py-8">
                <p class="text-gray-600">Data fasilitas sedang dalam proses pengunggahan.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Animasi scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.transform');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
                }
            });
        });

        elements.forEach(element => {
            element.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-1000');
            observer.observe(element);
        });
    });
</script>
@endpush 
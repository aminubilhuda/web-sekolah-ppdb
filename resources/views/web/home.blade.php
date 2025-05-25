@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Selamat datang di website resmi SMK - Sekolah Menengah Kejuruan terbaik dengan fokus pada pengembangan kompetensi siswa dalam bidang teknologi dan industri.')

@push('styles')
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            background-color: white;
            margin: 0;
            padding: 1rem;
            width: 70%;
            max-width: 600px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            animation: modalFadeIn 0.3s ease-out;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .close-modal {
            position: absolute;
            right: -1.5rem;
            top: -1.5rem;
            font-size: 1.25rem;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            z-index: 10;
            background: rgba(0, 0, 0, 0.5);
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .close-modal:hover {
            background: rgba(0, 0, 0, 0.7);
            transform: rotate(90deg);
        }

        .modal-image {
            width: 100%;
            height: auto;
            max-height: 70vh;
            object-fit: contain;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Hero Slider Styles */
        .hero-slider {
            position: relative;
            height: 100vh;
            background: #000;
        }

        .hero-slider::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(to bottom, 
                rgba(37, 99, 235, 0.5) 0%,
                rgba(37, 99, 235, 0.4) 20%,
                rgba(37, 99, 235, 0.3) 40%,
                rgba(37, 99, 235, 0.2) 60%,
                rgba(37, 99, 235, 0.1) 80%,
                transparent 100%);
            z-index: 1;
            pointer-events: none;
        }

        .hero-slider::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(135deg,
                rgba(37, 99, 235, 0.2) 0%,
                rgba(59, 130, 246, 0.2) 50%,
                rgba(37, 99, 235, 0.2) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            position: relative;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.2);
            transition: transform 1.5s ease;
        }

        .swiper-slide-active img {
            transform: scale(1);
        }

        .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 4rem;
            background: linear-gradient(to top, 
                rgba(0,0,0,0.9) 0%,
                rgba(0,0,0,0.7) 30%,
                rgba(0,0,0,0.4) 60%,
                transparent 100%);
            color: white;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.8s ease;
        }

        .swiper-slide-active .slide-content {
            transform: translateY(0);
            opacity: 1;
        }

        .slide-content h2 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(to right, #fff, #e2e8f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .slide-content p {
            font-size: 1.25rem;
            max-width: 600px;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            background: rgba(255,255,255,0.1);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.1);
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: white;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            transform: scale(1.2);
        }

        /* Decorative Elements */
        .decorative-wave {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 150px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%232563EB' fill-opacity='0.1' d='M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
            background-position: center;
            transform: rotate(180deg);
            z-index: 2;
            pointer-events: none;
        }

        .decorative-dots {
            position: absolute;
            top: 50px;
            left: 0;
            right: 0;
            height: 100px;
            background: 
                radial-gradient(circle at 50% 50%, rgba(37, 99, 235, 0.2) 1px, transparent 1px),
                radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.2) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.5;
            z-index: 2;
            pointer-events: none;
        }

        .decorative-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: 
                linear-gradient(90deg, transparent 0%, rgba(37, 99, 235, 0.1) 50%, transparent 100%),
                linear-gradient(180deg, transparent 0%, rgba(59, 130, 246, 0.1) 50%, transparent 100%);
            z-index: 2;
            pointer-events: none;
        }

        /* Features Section with Decorative Elements */
        .features-section {
            position: relative;
            padding: 6rem 0;
            background: linear-gradient(to bottom, #f8fafc, #ffffff);
            overflow: hidden;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(to bottom, 
                rgba(37, 99, 235, 0.05) 0%,
                rgba(37, 99, 235, 0.02) 50%,
                transparent 100%);
            z-index: 1;
        }

        .features-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L60 0 L60 60 L0 60 Z' fill='none' stroke='%232563EB' stroke-width='0.5' opacity='0.1'/%3E%3C/svg%3E") repeat;
            opacity: 0.1;
            z-index: 0;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.1);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transform: rotate(-10deg);
            transition: transform 0.4s ease;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .feature-card:hover .feature-icon {
            transform: rotate(0deg) scale(1.1);
        }

        .feature-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        /* News Section */
        .news-section {
            padding: 6rem 0;
            background: linear-gradient(to bottom, #ffffff, #f8fafc);
            position: relative;
        }

        .news-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, 
                rgba(37, 99, 235, 0.05) 0%,
                transparent 100%);
            z-index: 1;
        }

        .news-card {
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
            transition: all 0.4s ease;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.1);
        }

        .news-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .news-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, 
                transparent 0%,
                rgba(37, 99, 235, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .news-card:hover .news-image::after {
            opacity: 1;
        }

        .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .news-card:hover .news-image img {
            transform: scale(1.1);
        }

        .news-content {
            padding: 2rem;
            background: white;
        }

        .news-date {
            color: #2563EB;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .news-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 1rem;
            line-height: 1.3;
            transition: color 0.3s ease;
        }

        .news-card:hover .news-title {
            color: #2563EB;
        }

        .news-excerpt {
            color: #4B5563;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .read-more {
            color: #2563EB;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            color: #3B82F6;
        }

        .read-more svg {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .read-more:hover svg {
            transform: translateX(5px);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
            padding: 6rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L60 0 L60 60 L0 60 Z' fill='none' stroke='%23ffffff' stroke-width='0.5' opacity='0.1'/%3E%3C/svg%3E") repeat;
            opacity: 0.1;
        }

        .cta-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .cta-description {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .cta-button {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .cta-button-primary {
            background: white;
            color: #2563EB;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        .cta-button-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .cta-button-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 2px solid white;
            backdrop-filter: blur(5px);
        }

        .cta-button-secondary:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <!-- Modal Banner Highlight -->
    @if($profilSekolah && $profilSekolah->banner_highlight)
    <div id="bannerModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <img src="{{ asset('storage/' . $profilSekolah->banner_highlight) }}" alt="Banner Highlight" class="modal-image">
        </div>
    </div>
    @endif

    <!-- Hero Slider -->
    <div class="hero-slider">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @forelse ($sliders as $slider)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->judul ?? 'Slider Image' }}">
                        <div class="slide-content">
                            @if ($slider->judul)
                                <h2>{{ $slider->judul }}</h2>
                            @endif
                            @if ($slider->deskripsi)
                                <p>{{ $slider->deskripsi }}</p>
                            @endif
                            @if ($slider->link)
                                <a href="{{ $slider->link }}" class="cta-button cta-button-primary">Lihat Detail</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="slide-content">
                            <h2>Selamat Datang</h2>
                            <p>Tambahkan slider baru melalui dashboard admin.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="decorative-wave"></div>
        <div class="decorative-dots"></div>
        <div class="decorative-lines"></div>
    </div>

    <!-- Features Section -->
    <section class="features-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="relative">
                    <div class="absolute -top-20 -left-20 w-40 h-40 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="relative z-10">
                        <span class="text-blue-600 font-semibold text-lg mb-2 block">Keunggulan Kami</span>
                        <h2 class="text-4xl font-bold text-gray-900 sm:text-5xl mb-6">Mengapa Memilih Kami?</h2>
                        <p class="text-xl text-gray-600 mb-8">Kami menyediakan pendidikan berkualitas dengan fasilitas modern dan tenaga pengajar yang berpengalaman.</p>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Fasilitas Modern</h3>
                                    <p class="text-gray-600 mt-1">Laboratorium dan peralatan modern untuk pembelajaran yang efektif.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Kurikulum Terkini</h3>
                                    <p class="text-gray-600 mt-1">Kurikulum yang selalu diperbarui sesuai kebutuhan industri.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Guru Berpengalaman</h3>
                                    <p class="text-gray-600 mt-1">Tenaga pengajar yang kompeten dan berpengalaman.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right Content - Image Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="rounded-2xl overflow-hidden h-64">
                            <img src="{{ asset('images/facility-1.jpg') }}" alt="Fasilitas" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="rounded-2xl overflow-hidden h-48">
                            <img src="{{ asset('images/facility-2.jpg') }}" alt="Fasilitas" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                    <div class="space-y-4 mt-8">
                        <div class="rounded-2xl overflow-hidden h-48">
                            <img src="{{ asset('images/facility-3.jpg') }}" alt="Fasilitas" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="rounded-2xl overflow-hidden h-64">
                            <img src="{{ asset('images/facility-4.jpg') }}" alt="Fasilitas" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold text-lg mb-2 block">Berita Terbaru</span>
                <h2 class="text-4xl font-bold text-gray-900 sm:text-5xl mb-4">Informasi Terkini</h2>
                <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">Dapatkan informasi terbaru seputar kegiatan dan prestasi sekolah kami.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                @foreach($latestNews as $index => $news)
                    @if($index === 0)
                        <div class="lg:col-span-8">
                            <article class="news-card-featured group">
                                <div class="relative h-[500px] rounded-2xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->judul }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-8">
                                        <div class="text-white/80 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $news->created_at->format('d M Y') }}
                                        </div>
                                        <h3 class="text-3xl font-bold text-white mb-4 group-hover:text-blue-300">{{ $news->judul }}</h3>
                                        <p class="text-white/80 mb-6">{{ Str::limit(strip_tags($news->konten), 200) }}</p>
                                        <a href="{{ route('web.berita.show', $news->slug) }}" class="inline-flex items-center text-white hover:text-blue-300">
                                            Baca selengkapnya
                                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="lg:col-span-4 space-y-8">
                    @else
                        <article class="news-card-compact group">
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0 w-32 h-32 rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->judul }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="text-blue-600 text-sm mb-2">{{ $news->created_at->format('d M Y') }}</div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600">{{ $news->judul }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit(strip_tags($news->konten), 80) }}</p>
                                    <a href="{{ route('web.berita.show', $news->slug) }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">
                                        Baca selengkapnya
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('web.berita.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    Lihat Semua Berita
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 to-blue-800">
                <div class="absolute inset-0">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:60px_60px]"></div>
                </div>
                <div class="relative py-16 px-6 sm:py-24 sm:px-12 lg:px-16">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                        <div>
                            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                Siap untuk Memulai Perjalanan Belajarmu?
                            </h2>
                            <p class="mt-4 text-lg text-blue-100">
                                Daftar sekarang untuk tahun ajaran baru dan wujudkan impianmu bersama kami dalam lingkungan belajar yang inspiratif.
                            </p>
                            <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('web.ppdb.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                                    Daftar PPDB
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('web.contact.index') }}" class="inline-flex items-center justify-center px-6 py-3 border-2 border-white text-base font-medium rounded-full text-white hover:bg-white/10 transition-colors">
                                    Hubungi Kami
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="mt-12 lg:mt-0">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-2xl blur opacity-25"></div>
                                <div class="relative bg-white/10 backdrop-blur-sm rounded-2xl p-8">
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-white">Pendaftaran Dibuka</h3>
                                                <p class="text-blue-100">Tahun Ajaran 2024/2025</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-white">Kuota Terbatas</h3>
                                                <p class="text-blue-100">Segera daftarkan dirimu</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
@endsection

@push('scripts')
    <!-- Link Swiper's JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const modal = document.getElementById('bannerModal');
            const closeBtn = document.querySelector('.close-modal');

            // Show modal when page loads
            if (modal) {
                // Add a small delay before showing the modal
                setTimeout(() => {
                    modal.style.display = 'block';
                }, 1000);
            }

            // Close modal when clicking the close button
            if (closeBtn) {
                closeBtn.onclick = function() {
                    modal.style.display = 'none';
                }
            }

            // Close modal when clicking outside the modal content
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // Initialize Swiper with enhanced effects
            @if ($sliders->count() > 0)
                var swiper = new Swiper(".mySwiper", {
                    effect: "fade",
                    speed: 1000,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    loop: true,
                    on: {
                        slideChangeTransitionStart: function () {
                            const activeSlide = this.slides[this.activeIndex];
                            const content = activeSlide.querySelector('.slide-content');
                            if (content) {
                                content.style.opacity = '0';
                                content.style.transform = 'translateY(100px)';
                            }
                        },
                        slideChangeTransitionEnd: function () {
                            const activeSlide = this.slides[this.activeIndex];
                            const content = activeSlide.querySelector('.slide-content');
                            if (content) {
                                content.style.opacity = '1';
                                content.style.transform = 'translateY(0)';
                            }
                        }
                    }
                });
            @endif

            // Animate elements on scroll
            const animateOnScroll = () => {
                const elements = document.querySelectorAll('.feature-card, .news-card');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementBottom = element.getBoundingClientRect().bottom;
                    
                    if (elementTop < window.innerHeight && elementBottom > 0) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };

            // Set initial state
            document.querySelectorAll('.feature-card, .news-card').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'all 0.6s ease';
            });

            // Add scroll event listener
            window.addEventListener('scroll', animateOnScroll);
            // Initial check
            animateOnScroll();
        });
    </script>
@endpush 
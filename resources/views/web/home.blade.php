@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Selamat datang di website resmi SMK - Sekolah Menengah Kejuruan terbaik dengan fokus pada pengembangan kompetensi siswa dalam bidang teknologi dan industri.')

@push('styles')
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Global Variables */
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #10b981;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-xl: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
        }

        /* Modal Banner Highlight Styles */
        .banner-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }

        .banner-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .banner-modal-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            animation: scaleIn 0.3s ease-out;
            margin: auto;
        }

        .banner-modal-image {
            width: 100%;
            height: auto;
            display: block;
            max-height: 80vh;
            object-fit: contain;
            transition: opacity 0.3s ease;
        }

        .banner-modal-image.loading {
            opacity: 0.5;
        }

        .banner-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        .banner-modal-close:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .banner-modal-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px 25px;
            border-radius: 10px;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from { 
                opacity: 0;
                transform: scale(0.8) translate(-50%, -50%);
            }
            to { 
                opacity: 1;
                transform: scale(1) translate(-50%, -50%);
            }
        }

        /* Responsive Design untuk Modal */
        @media (max-width: 768px) {
            .banner-modal-content {
                max-width: 95vw;
                max-height: 85vh;
                border-radius: 15px;
            }

            .banner-modal.show {
                padding: 10px;
            }

            .banner-modal-close {
                top: 10px;
                right: 10px;
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .banner-modal-content {
                max-width: 98vw;
                max-height: 80vh;
                border-radius: 10px;
            }

            .banner-modal.show {
                padding: 5px;
            }
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 100vh;
            background: var(--gradient-1);
            overflow: hidden;
            display: flex;
            align-items: center;
            margin-top: -64px; /* Negative margin untuk mengkompensasi header */
        }

        /* Ketika navbar menjadi fixed, hero section perlu menyesuaikan */
        .hero-section-scrolled {
            margin-top: 0;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 1px 1px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .hero-blob {
            position: absolute;
            border-radius: 50%;
            mix-blend-mode: multiply;
            filter: blur(40px);
            animation: blob 7s infinite;
        }

        .hero-blob:nth-child(1) {
            top: 0;
            left: 0;
            width: 300px;
            height: 300px;
            background: rgba(59, 130, 246, 0.3);
            animation-delay: 0s;
        }

        .hero-blob:nth-child(2) {
            top: 50%;
            right: 0;
            width: 250px;
            height: 250px;
            background: rgba(16, 185, 129, 0.3);
            animation-delay: 2s;
        }

        .hero-blob:nth-child(3) {
            bottom: 0;
            left: 50%;
            width: 200px;
            height: 200px;
            background: rgba(245, 87, 108, 0.3);
            animation-delay: 4s;
        }

        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .hero-content {
            position: relative;
            z-index: 20;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            margin-bottom: 2rem;
            line-height: 1.1;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.5s forwards;
            position: relative;
            z-index: 21;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0;
            animation: slideInUp 1s ease-out 0.8s forwards;
            position: relative;
            z-index: 21;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: slideInUp 1s ease-out 1.1s forwards;
            position: relative;
            z-index: 21;
        }

        .btn-hero {
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-lg);
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: var(--primary-color);
        }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slider Styles untuk Hero */
        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .swiper-slide {
            position: relative;
            height: 100vh;
        }

        .slide-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .slide-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 20;
            width: 90%;
            max-width: 800px;
        }

        /* Stats Section */
        .stats-section {
            padding: 6rem 0;
            background: var(--light-color);
            position: relative;
            z-index: 40;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative !important;
            z-index: 999997 !important;
            transform: translateZ(0);
            isolation: isolate;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .stat-card {
            background: white;
            padding: 3.5rem 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative !important;
            overflow: visible;
            z-index: 999998 !important;
            transform: translateZ(0);
            isolation: isolate;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-1);
            z-index: 51;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            z-index: 55;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative !important;
            z-index: 999999 !important;
            transform: translateZ(0);
            isolation: isolate;
            display: block;
            line-height: 1.1;
            text-shadow: 0 2px 4px rgba(30, 64, 175, 0.1);
            min-height: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-label {
            font-size: 1.2rem;
            color: var(--dark-color);
            font-weight: 600;
            position: relative !important;
            z-index: 999999 !important;
            transform: translateZ(0);
            isolation: isolate;
            display: block;
            line-height: 1.3;
        }

        /* About Section */
        .about-section {
            padding: 8rem 0;
            background: white;
            position: relative;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
        }

        .about-content h2 {
            font-size: 3rem;
            font-weight: 900;
            color: var(--dark-color);
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .about-content .highlight {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .about-content p {
            font-size: 1.2rem;
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon svg {
            width: 30px;
            height: 30px;
            color: white;
        }

        .feature-text {
            font-weight: 600;
            color: var(--dark-color);
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
        }

        .image-card {
            position: absolute;
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            max-width: 200px;
        }

        .image-card-1 {
            top: -20px;
            left: -20px;
            background: var(--gradient-2);
            color: white;
        }

        .image-card-2 {
            bottom: -20px;
            right: -20px;
            background: var(--gradient-3);
            color: white;
        }

        /* Programs Section */
        .programs-section {
            padding: 8rem 0;
            background: var(--light-color);
        }

        .programs-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 6rem;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
        }

        .section-subtitle {
            font-size: 1.3rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
        }

        .program-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .program-card:hover {
            transform: translateY(-15px);
            box-shadow: var(--shadow-xl);
        }

        .program-header {
            padding: 2.5rem;
            background: var(--gradient-1);
            color: white;
            text-align: center;
            position: relative;
        }

        .program-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .program-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        .program-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .program-content {
            padding: 2.5rem;
        }

        .program-description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .program-features {
            list-style: none;
            padding: 0;
        }

        .program-features li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .program-features li::before {
            content: '✓';
            width: 20px;
            height: 20px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* News Section */
        .news-section {
            padding: 8rem 0;
            background: white;
        }

        .news-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .news-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 4rem;
            margin-top: 4rem;
        }

        .featured-news {
            position: relative;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .featured-news:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .featured-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .featured-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 3rem;
            color: white;
        }

        .featured-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .featured-excerpt {
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .featured-date {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .news-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .news-item {
            background: var(--light-color);
            padding: 2rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .news-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .news-item-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .news-item-excerpt {
            color: #6b7280;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .news-item-date {
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            padding: 8rem 0;
            background: var(--gradient-1);
            position: relative;
            overflow: hidden;
        }

        .cta-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image: 
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .cta-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .cta-title {
            font-size: 3.5rem;
            font-weight: 900;
            color: white;
            margin-bottom: 2rem;
            line-height: 1.2;
        }

        .cta-description {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .about-grid { grid-template-columns: 1fr; gap: 4rem; }
            .news-grid { grid-template-columns: 1fr; gap: 3rem; }
            .section-title { font-size: 2.2rem; }
            .cta-title { font-size: 2.5rem; }
            .about-features { grid-template-columns: 1fr; }
            .hero-buttons { flex-direction: column; align-items: center; }
            .cta-buttons { flex-direction: column; align-items: center; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2rem; }
            .programs-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }

        /* Utility Classes */
        .btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--gradient-1);
            color: white;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
    <!-- Modal Banner Highlight -->
    @if($profilSekolah && $profilSekolah->banner_highlight)
    <div id="bannerModal" class="banner-modal">
        <div class="banner-modal-content">
            <button class="banner-modal-close" onclick="closeBannerModal()" aria-label="Tutup Modal">&times;</button>
            <div id="bannerModalLoading" class="banner-modal-loading" style="display: none;">
                Memuat gambar...
            </div>
            <img id="bannerModalImage" 
                 src="{{ asset('storage/' . $profilSekolah->banner_highlight) }}" 
                 alt="Banner Highlight - {{ $profilSekolah->nama_sekolah ?? 'Sekolah' }}" 
                 class="banner-modal-image"
                 onload="handleImageLoad()"
                 onerror="handleImageError()">
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="hero-blob"></div>
            <div class="hero-blob"></div>
            <div class="hero-blob"></div>
        </div>

        @if($sliders->count() > 0)
        <!-- Hero Slider -->
        <div class="hero-slider">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($sliders as $slider)
                    <div class="swiper-slide">
                        <div class="slide-bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}')"></div>
                        <div class="slide-overlay"></div>
                        <div class="slide-content">
                            @if ($slider->judul)
                                <h1 class="hero-title">{{ $slider->judul }}</h1>
                            @endif
                            @if ($slider->deskripsi)
                                <p class="hero-subtitle">{{ $slider->deskripsi }}</p>
                            @endif
                            @if ($slider->link)
                                <div class="hero-buttons">
                                    <a href="{{ $slider->link }}" class="btn-hero btn-hero-primary">
                                        Pelajari Lebih Lanjut
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        @else
        <!-- Static Hero Content -->
        <div class="hero-content">
            <h1 class="hero-title">Masa Depan Cerah<br>Dimulai dari Sini</h1>
            <p class="hero-subtitle">Bergabunglah dengan SMK terdepan yang menghadirkan pendidikan berkualitas tinggi dengan teknologi modern dan pengajar berpengalaman</p>
            <div class="hero-buttons">
                <a href="{{ route('web.ppdb.index') }}" class="btn-hero btn-hero-primary">
                    Daftar Sekarang
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="{{ route('web.profil.index') }}" class="btn-hero btn-hero-secondary">
                    Tentang Kami
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>
            </div>
        </div>
        @endif
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="section-header">
                <h2 class="section-title">Prestasi yang Membanggakan</h2>
                <p class="section-subtitle">Angka-angka yang menunjukkan komitmen kami dalam memberikan pendidikan terbaik</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card fade-in">
                    <div class="stat-number" data-count="{{ $stats['alumni'] }}">0</div>
                    <div class="stat-label">Alumni Sukses</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number" data-count="{{ $stats['guru'] }}">0</div>
                    <div class="stat-label">Guru Profesional</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number" data-count="{{ $stats['jurusan'] }}">0</div>
                    <div class="stat-label">Program Keahlian</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-number" data-count="{{ $stats['kelulusan'] }}">0</div>
                    <div class="stat-label">% Tingkat Kelulusan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="about-container">
            <div class="about-grid">
                <div class="about-content fade-in">
                    <h2>Membangun <span class="highlight">Generasi Unggul</span> untuk Masa Depan</h2>
                    <p>Kami berkomitmen memberikan pendidikan vokasi terbaik yang menggabungkan teori dan praktik, mempersiapkan siswa dengan keterampilan yang dibutuhkan industri modern.</p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <span class="feature-text">Pembelajaran Inovatif</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <span class="feature-text">Laboratorium Modern</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="feature-text">Guru Berpengalaman</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <span class="feature-text">Sertifikasi Industri</span>
                        </div>
                    </div>
                </div>
                
                <div class="about-image fade-in">
                    @if($fasilitas->count() > 0)
                        <img src="{{ asset('storage/' . $fasilitas[0]->image) }}" alt="{{ $fasilitas[0]->nama }}">
                    @else
                        <img src="{{ asset('images/default-facility.jpg') }}" alt="Fasilitas Sekolah">
                    @endif
                    
                    <div class="image-card image-card-1">
                        <h4 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">15+</h4>
                        <p style="margin: 0; opacity: 0.9;">Tahun Pengalaman</p>
                    </div>
                    
                    <div class="image-card image-card-2">
                        <h4 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">95%</h4>
                        <p style="margin: 0; opacity: 0.9;">Lulusan Bekerja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section">
        <div class="programs-container">
            <div class="section-header">
                <h2 class="section-title">Program Keahlian Unggulan</h2>
                <p class="section-subtitle">Pilih program keahlian yang sesuai dengan minat dan bakat Anda</p>
            </div>
            
            <div class="programs-grid">
                @forelse($jurusans as $jurusan)
                <div class="program-card fade-in">
                    <div class="program-header">
                        <div class="program-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <h3 class="program-title">{{ $jurusan->nama_jurusan }}</h3>
                    </div>
                    <div class="program-content">
                        <p class="program-description">{{ $jurusan->deskripsi ?: 'Program keahlian yang mempersiapkan siswa dengan kemampuan praktis dan teoritis sesuai dengan kebutuhan industri modern.' }}</p>
                        <ul class="program-features">
                            <li>Kurikulum Terbaru</li>
                            <li>Praktik Industri</li>
                            <li>Sertifikasi Profesi</li>
                            <li>{{ $jurusan->kepalaJurusan ? 'Dipimpin ' . $jurusan->kepalaJurusan->nama : 'Tim Pengajar Berpengalaman' }}</li>
                        </ul>
                    </div>
                </div>
                @empty
                <!-- Default programs jika belum ada data jurusan -->
                <div class="program-card fade-in">
                    <div class="program-header">
                        <div class="program-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                            </svg>
                        </div>
                        <h3 class="program-title">Teknik Komputer & Jaringan</h3>
                    </div>
                    <div class="program-content">
                        <p class="program-description">Program keahlian yang mempersiapkan siswa untuk menjadi teknisi komputer dan jaringan profesional dengan kemampuan instalasi, konfigurasi, dan maintenance sistem.</p>
                        <ul class="program-features">
                            <li>Hardware & Software</li>
                            <li>Networking & Security</li>
                            <li>Troubleshooting System</li>
                            <li>Sertifikasi Internasional</li>
                        </ul>
                    </div>
                </div>
                
                <div class="program-card fade-in">
                    <div class="program-header">
                        <div class="program-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <h3 class="program-title">Rekayasa Perangkat Lunak</h3>
                    </div>
                    <div class="program-content">
                        <p class="program-description">Mempersiapkan siswa menjadi programmer dan software developer handal dengan kemampuan merancang, mengembangkan, dan memelihara aplikasi software.</p>
                        <ul class="program-features">
                            <li>Programming Languages</li>
                            <li>Web & Mobile Development</li>
                            <li>Database Management</li>
                            <li>Project Management</li>
                        </ul>
                    </div>
                </div>
                
                <div class="program-card fade-in">
                    <div class="program-header">
                        <div class="program-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="program-title">Akuntansi & Keuangan</h3>
                    </div>
                    <div class="program-content">
                        <p class="program-description">Program yang menghasilkan tenaga ahli di bidang akuntansi dan keuangan dengan kemampuan mengelola pembukuan dan laporan keuangan perusahaan.</p>
                        <ul class="program-features">
                            <li>Financial Accounting</li>
                            <li>Computer Accounting</li>
                            <li>Tax Management</li>
                            <li>Business Analysis</li>
                        </ul>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- News Section -->
    @if($latestNews->count() > 0)
    <section class="news-section">
        <div class="news-container">
            <div class="section-header">
                <h2 class="section-title">Berita & Informasi Terkini</h2>
                <p class="section-subtitle">Dapatkan update terbaru tentang kegiatan dan prestasi sekolah</p>
            </div>
            
            <div class="news-grid">
                <div class="featured-news fade-in" onclick="window.location.href='{{ route('web.berita.show', $latestNews[0]->slug) }}'">
                    <img src="{{ asset('storage/' . $latestNews[0]->image) }}" alt="{{ $latestNews[0]->judul }}" class="featured-image">
                    <div class="featured-overlay">
                        <div class="featured-date">{{ $latestNews[0]->created_at->format('d M Y') }}</div>
                        <h3 class="featured-title">{{ $latestNews[0]->judul }}</h3>
                        <p class="featured-excerpt">{{ Str::limit(strip_tags($latestNews[0]->konten), 120) }}</p>
                    </div>
                </div>
                
                <div class="news-list">
                    @foreach($latestNews->skip(1)->take(3) as $news)
                    <div class="news-item fade-in" onclick="window.location.href='{{ route('web.berita.show', $news->slug) }}'">
                        <h4 class="news-item-title">{{ $news->judul }}</h4>
                        <p class="news-item-excerpt">{{ Str::limit(strip_tags($news->konten), 80) }}</p>
                        <div class="news-item-date">{{ $news->created_at->format('d M Y') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 4rem;">
                <a href="{{ route('web.berita.index') }}" class="btn btn-primary">
                    Lihat Semua Berita
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-pattern"></div>
        <div class="cta-container">
            <h2 class="cta-title">Siap Memulai Perjalanan Menuju Sukses?</h2>
            <p class="cta-description">Bergabunglah dengan ribuan alumni sukses yang telah memulai karir gemilang dari SMK kami. Masa depan cerah menanti Anda!</p>
            <div class="cta-buttons">
                <a href="{{ route('web.ppdb.index') }}" class="btn-hero btn-hero-primary">
                    Daftar SPMB
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="{{ route('web.contact.index') }}" class="btn-hero btn-hero-secondary">
                    Hubungi Kami
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Banner Modal Handler
    @if($profilSekolah && $profilSekolah->banner_highlight)
    if (shouldShowModal()) {
        // Tampilkan modal setelah 1 detik
        setTimeout(function() {
            showBannerModal();
        }, 1000);
        
        // Simpan tanggal hari ini ke localStorage
        const today = new Date().toDateString();
        localStorage.setItem('bannerModalLastShown', today);
    }
    @endif

    // Initialize Swiper if sliders exist
    @if ($sliders->count() > 0)
    const swiper = new Swiper('.mySwiper', {
        effect: 'fade',
        speed: 1000,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
    });
    @endif

    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });

    // Counter animation
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start);
            }
        }, 16);
    }

    // Animate stats when visible
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target.querySelector('.stat-number');
                const target = parseInt(counter.getAttribute('data-count'));
                animateCounter(counter, target);
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-card').forEach(card => {
        statsObserver.observe(card);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Banner Modal Functions
function showBannerModal() {
    const modal = document.getElementById('bannerModal');
    const image = document.getElementById('bannerModalImage');
    const loading = document.getElementById('bannerModalLoading');
    
    if (modal && image) {
        // Show loading
        loading.style.display = 'block';
        image.classList.add('loading');
        
        // Show modal
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
        
        // Check if image is already loaded
        if (image.complete && image.naturalHeight !== 0) {
            handleImageLoad();
        }
    }
}

function closeBannerModal() {
    const modal = document.getElementById('bannerModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }
}

function handleImageLoad() {
    const image = document.getElementById('bannerModalImage');
    const loading = document.getElementById('bannerModalLoading');
    
    if (image && loading) {
        loading.style.display = 'none';
        image.classList.remove('loading');
    }
}

function handleImageError() {
    const modal = document.getElementById('bannerModal');
    const loading = document.getElementById('bannerModalLoading');
    
    if (loading) {
        loading.innerHTML = 'Gagal memuat gambar';
        setTimeout(() => {
            closeBannerModal();
        }, 2000);
    }
}

// Close modal when clicking outside of it
document.addEventListener('click', function(event) {
    const modal = document.getElementById('bannerModal');
    const modalContent = document.querySelector('.banner-modal-content');
    
    if (modal && event.target === modal && !modalContent?.contains(event.target)) {
        closeBannerModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeBannerModal();
    }
});

// Prevent modal from showing if user prefers reduced motion
function shouldShowModal() {
    @if($profilSekolah && $profilSekolah->banner_highlight)
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) {
        return false;
    }
    
    const today = new Date().toDateString();
    const lastShown = localStorage.getItem('bannerModalLastShown');
    
    return lastShown !== today;
    @else
    return false;
    @endif
}
</script>
@endpush 
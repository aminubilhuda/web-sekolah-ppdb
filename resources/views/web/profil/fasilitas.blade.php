@extends('layouts.app')

@section('title', 'Fasilitas')
@section('meta_description', 'Fasilitas modern dan lengkap yang tersedia di SMK kami untuk mendukung proses pembelajaran yang efektif.')

@push('styles')
<style>
    .facility-section {
        padding: 6rem 0;
        background: linear-gradient(to bottom, #f8fafc, #ffffff);
    }

    .facility-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .facility-card {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1);
        transition: all 0.3s ease;
    }

    .facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.1);
    }

    .facility-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .facility-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .facility-card:hover .facility-image img {
        transform: scale(1.1);
    }

    .facility-content {
        padding: 1.5rem;
    }

    .facility-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 0.5rem;
    }

    .facility-description {
        color: #4B5563;
        line-height: 1.6;
    }

    .facility-icon {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .facility-icon svg {
        width: 20px;
        height: 20px;
        color: #2563EB;
    }

    .page-header {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        padding: 4rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L60 0 L60 60 L0 60 Z' fill='none' stroke='%23ffffff' stroke-width='0.5' opacity='0.1'/%3E%3C/svg%3E") repeat;
        opacity: 0.1;
    }

    .page-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-description {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 600px;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="page-title">Fasilitas Sekolah</h1>
            <p class="page-description">Kami menyediakan berbagai fasilitas modern untuk mendukung proses pembelajaran yang efektif dan menyenangkan.</p>
        </div>
    </div>

    <!-- Facility Section -->
    <section class="facility-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="facility-grid">
                @foreach($fasilitas as $fasil)
                <div class="facility-card">
                    <div class="facility-image">
                        <img src="{{ asset('storage/' . $fasil->image) }}" alt="{{ $fasil->nama }}">
                        <div class="facility-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="facility-content">
                        <h3 class="facility-title">{{ $fasil->nama }}</h3>
                        <p class="facility-description">{{ $fasil->deskripsi }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection 
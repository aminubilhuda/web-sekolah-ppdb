@extends('layouts.app')

@section('title', $fasilitas->nama . ' - Fasilitas')
@section('meta_description', strip_tags($fasilitas->deskripsi))

@push('styles')
<style>
    .facility-detail-section {
        padding: 3rem 0;
        background: #f8fafc;
    }

    .facility-hero {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        padding: 4rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .facility-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0 L60 0 L60 60 L0 60 Z' fill='none' stroke='%23ffffff' stroke-width='0.5' opacity='0.1'/%3E%3C/svg%3E") repeat;
        opacity: 0.1;
    }

    .breadcrumb {
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .facility-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .facility-image-main {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
    }

    .facility-content {
        background: white;
        padding: 3rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        max-width: 4xl;
        margin: 0 auto;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .related-facilities {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 1px solid #e5e7eb;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .related-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        color: inherit;
    }

    .related-image {
        height: 150px;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-content {
        padding: 1rem;
    }

    .no-image {
        background: linear-gradient(45deg, #f3f4f6, #e5e7eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        height: 100%;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: white;
        color: #2563eb;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .btn-back:hover {
        background: #f8fafc;
        transform: translateY(-1px);
        text-decoration: none;
        color: #1d4ed8;
    }

    .btn-back svg {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
    }

    @media (max-width: 768px) {
        .facility-title {
            font-size: 2rem;
        }
        
        .facility-image-main {
            height: 250px;
        }

        .facility-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Facility Hero -->
    <div class="facility-hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="breadcrumb">
                <a href="{{ route('web.profil.fasilitas') }}">Fasilitas</a> / 
                {{ $fasilitas->nama }}
            </div>
            <h1 class="facility-title">{{ $fasilitas->nama }}</h1>
            <div class="status-badge status-{{ $fasilitas->status }}">
                {{ $fasilitas->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
            </div>
        </div>
    </div>

    <!-- Facility Detail Section -->
    <section class="facility-detail-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('web.profil.fasilitas') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Fasilitas
            </a>

            <!-- Main Image -->
            @if($fasilitas->image)
                <img src="{{ asset('storage/' . $fasilitas->image) }}" 
                     alt="{{ $fasilitas->nama }}" 
                     class="facility-image-main">
            @endif

            <!-- Main Content -->
            <div class="facility-content">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                <div class="prose prose-blue max-w-none">
                    {!! $fasilitas->deskripsi !!}
                </div>
            </div>

            <!-- Related Facilities -->
            @if($fasilitasLainnya && $fasilitasLainnya->count() > 0)
                <div class="related-facilities">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Fasilitas Lainnya</h2>
                    <div class="related-grid">
                        @foreach($fasilitasLainnya as $related)
                            <a href="{{ route('fasilitas.show', $related->slug) }}" class="related-card">
                                <div class="related-image">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->nama }}">
                                    @else
                                        <div class="no-image">
                                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="related-content">
                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $related->nama }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {!! Str::limit(strip_tags($related->deskripsi), 80) !!}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection 
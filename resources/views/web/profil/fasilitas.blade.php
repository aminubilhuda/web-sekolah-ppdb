@extends('layouts.app')

@section('title', 'Fasilitas Sekolah')

@push('styles')
<style>
    .facility-section {
        padding: 3rem 0;
        background: #f8fafc;
    }

    .facility-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .facility-card {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .facility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .facility-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .facility-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .facility-card:hover .facility-image img {
        transform: scale(1.05);
    }

    .facility-content {
        padding: 1.5rem;
    }

    .facility-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .facility-description {
        color: #6b7280;
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .facility-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background: #10b981;
        color: white;
    }

    .status-inactive {
        background: #ef4444;
        color: white;
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

    .no-image {
        background: linear-gradient(45deg, #f3f4f6, #e5e7eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .facility-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .facility-link:hover {
        color: inherit;
        text-decoration: none;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #2563eb;
        color: white;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-detail:hover {
        background: #1d4ed8;
        color: white;
        text-decoration: none;
    }

    .btn-detail svg {
        width: 1rem;
        height: 1rem;
        margin-left: 0.5rem;
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
            @if($fasilitas->count() > 0)
                <div class="facility-grid">
                    @foreach($fasilitas as $fasil)
                    <div class="facility-card">
                        <div class="facility-image">
                            @if($fasil->image)
                                <img src="{{ asset('storage/' . $fasil->image) }}" alt="{{ $fasil->nama }}">
                            @else
                                <div class="no-image">
                                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="facility-status status-{{ $fasil->status }}">
                                {{ $fasil->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </div>
                        </div>
                        <div class="facility-content">
                            <h3 class="facility-title">{{ $fasil->nama }}</h3>
                            <div class="facility-description">
                                {!! Str::limit(strip_tags($fasil->deskripsi), 120) !!}
                            </div>
                            
                            <a href="{{ route('fasilitas.show', $fasil->slug) }}" class="btn-detail">
                                Lihat Detail
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $fasilitas->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada fasilitas</h3>
                    <p class="text-gray-500">Fasilitas belum tersedia saat ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection 
@extends('layouts.app')

@section('title', $guru->nama . ' - Guru')
@section('meta_description', 'Profil ' . $guru->nama . ' - ' . $guru->jabatan . ' ' . $guru->bidang_studi)

@push('styles')
<style>
    .guru-detail-section {
        padding: 3rem 0;
        background: #f8fafc;
    }

    .guru-hero {
        background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        padding: 4rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .guru-hero::before {
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

    .guru-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .guru-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .guru-profile {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 3rem;
        margin-top: 3rem;
    }

    .guru-image {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .guru-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .guru-content {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        padding: 1rem;
        background: #f8fafc;
        border-radius: 0.5rem;
        border-left: 4px solid #2563eb;
    }

    .info-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .info-value {
        color: #1f2937;
        font-size: 1rem;
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

    .no-image {
        background: linear-gradient(45deg, #f3f4f6, #e5e7eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        height: 400px;
    }

    @media (max-width: 768px) {
        .guru-title {
            font-size: 2rem;
        }
        
        .guru-profile {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <!-- Guru Hero -->
    <div class="guru-hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="breadcrumb">
                <a href="{{ route('web.guru.index') }}">Guru</a> / 
                {{ $guru->nama }}
            </div>
            <h1 class="guru-title">{{ $guru->nama }}</h1>
            <p class="guru-subtitle">{{ $guru->jabatan }} - {{ $guru->bidang_studi }}</p>
            @if($guru->nip)
                <p class="opacity-75">NIP: {{ $guru->nip }}</p>
            @endif
        </div>
    </div>

    <!-- Guru Detail Section -->
    <section class="guru-detail-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('web.guru.index') }}" class="btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Guru
            </a>

            <div class="guru-profile">
                <!-- Guru Image -->
                <div class="guru-image">
                    @if($guru->foto)
                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama }}">
                    @else
                        <div class="no-image">
                            <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Guru Content -->
                <div class="guru-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Informasi Personal</h2>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Jenis Kelamin</div>
                            <div class="info-value">{{ $guru->jenis_kelamin }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Tempat, Tanggal Lahir</div>
                            <div class="info-value">{{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir->format('d F Y') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Agama</div>
                            <div class="info-value">{{ $guru->agama }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">No. HP</div>
                            <div class="info-value">{{ $guru->no_hp }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $guru->email }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $guru->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $guru->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-item mb-4">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $guru->alamat }}</div>
                    </div>

                    @if($guru->deskripsi)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                            <div class="prose prose-blue max-w-none">
                                {!! nl2br(e($guru->deskripsi)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection 
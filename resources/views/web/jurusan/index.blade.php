@extends('layouts.app')

@section('title', 'Jurusan')
@section('meta_description', 'Informasi tentang jurusan-jurusan yang tersedia di sekolah kami')

@push('styles')
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 50;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        width: 90%;
        max-width: 800px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .close-modal {
        position: absolute;
        right: 1rem;
        top: 1rem;
        font-size: 1.5rem;
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
    }

    .close-modal:hover {
        background: rgba(0, 0, 0, 0.7);
    }

    .modal-image {
        width: 100%;
        height: auto;
        border-radius: 0.5rem 0.5rem 0 0;
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

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Jurusan</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($jurusans as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_jurusan }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">Tidak ada gambar</span>
                </div>
            @endif
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('web.jurusan.show', $item->id) }}" class="text-gray-900 hover:text-primary-600">
                        {{ $item->nama_jurusan }}
                    </a>
                </h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($item->deskripsi, 150) }}</p>
                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <span>Kepala Jurusan: {{ $item->kepalaJurusan->nama ?? 'Belum ditentukan' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm {{ $item->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $item->status ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                    <a href="{{ route('web.jurusan.show', $item->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                        Pelajari lebih lanjut →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500">Belum ada jurusan yang ditambahkan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const modal = document.getElementById('bannerModal');
        const closeBtn = document.querySelector('.close-modal');

        // Show modal when page loads
        if (modal) {
            modal.style.display = 'block';
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
    });
</script>
@endpush 
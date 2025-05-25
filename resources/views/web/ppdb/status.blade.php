@extends('layouts.app')

@section('title', 'Status Pendaftaran PPDB')
@section('meta_description', 'Cek status pendaftaran PPDB tahun ajaran 2024/2025')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Status Pendaftaran PPDB</h1>

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <form action="{{ route('web.ppdb.status') }}" method="GET" class="mb-8">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="no_pendaftaran" class="block text-sm font-medium text-gray-700">Nomor Pendaftaran</label>
                        <input type="text" name="no_pendaftaran" id="no_pendaftaran" value="{{ request('no_pendaftaran') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Masukkan nomor pendaftaran">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cek Status
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($pendaftaran))
            <div class="border rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Status Pendaftaran</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($pendaftaran->status == 'pending')
                            bg-yellow-100 text-yellow-800
                        @elseif($pendaftaran->status == 'approved')
                            bg-green-100 text-green-800
                        @elseif($pendaftaran->status == 'rejected')
                            bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($pendaftaran->status) }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Data Pendaftar</h3>
                        <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $pendaftaran->nama }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Asal Sekolah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $pendaftaran->asal_sekolah }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jurusan Pilihan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $pendaftaran->jurusan->nama }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Daftar</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $pendaftaran->created_at->format('d F Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    @if($pendaftaran->status == 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <h3 class="text-lg font-medium text-green-800 mb-2">Selamat! Anda Diterima</h3>
                        <p class="text-green-700 mb-4">Silakan lakukan daftar ulang dengan membawa dokumen asli ke sekolah pada tanggal yang telah ditentukan.</p>
                        <div class="space-y-2">
                            <p class="text-sm text-green-600"><strong>Tanggal Daftar Ulang:</strong> 11 - 15 Juli 2024</p>
                            <p class="text-sm text-green-600"><strong>Waktu:</strong> 08:00 - 15:00 WIB</p>
                            <p class="text-sm text-green-600"><strong>Tempat:</strong> Ruang PPDB SMK Negeri 1 Jakarta</p>
                        </div>
                    </div>
                    @elseif($pendaftaran->status == 'rejected')
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <h3 class="text-lg font-medium text-red-800 mb-2">Mohon Maaf</h3>
                        <p class="text-red-700">Pendaftaran Anda tidak dapat diproses karena beberapa alasan:</p>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach($pendaftaran->keterangan as $ket)
                            <li>{{ $ket }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <h3 class="text-lg font-medium text-yellow-800 mb-2">Pendaftaran Sedang Diproses</h3>
                        <p class="text-yellow-700">Pendaftaran Anda sedang diverifikasi oleh panitia PPDB. Silakan cek kembali status pendaftaran Anda beberapa saat lagi.</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('web.ppdb.index') }}" class="text-primary-600 hover:text-primary-500">
                    Kembali ke Halaman PPDB
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
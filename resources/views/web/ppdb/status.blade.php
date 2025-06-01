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

            <form action="{{ route('web.ppdb.check') }}" method="GET" class="mb-8">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="nomor_pendaftaran" class="block text-sm font-medium text-gray-700">Nomor Pendaftaran</label>
                        <input type="text" name="nomor_pendaftaran" id="nomor_pendaftaran" value="{{ request('nomor_pendaftaran') }}" required
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

            @if(isset($ppdb))
            <div class="border rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Status Pendaftaran</h2>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($ppdb->status == 'Menunggu')
                            bg-yellow-100 text-yellow-800
                        @elseif($ppdb->status == 'Diterima')
                            bg-green-100 text-green-800
                        @elseif($ppdb->status == 'Ditolak')
                            bg-red-100 text-red-800
                        @endif">
                        {{ $ppdb->status }}
                    </span>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Data Pendaftar</h3>
                        <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->nama_lengkap }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">NISN</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->nisn }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">NIK</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Asal Sekolah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->asal_sekolah }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tahun Lulus</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->tahun_lulus }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Jurusan Pilihan</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->jurusan->nama_jurusan ?? 'Tidak ditemukan' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Daftar</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->created_at->format('d F Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Data Orang Tua</h3>
                        <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Ayah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->nama_ayah }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pekerjaan Ayah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->pekerjaan_ayah }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">No. HP Ayah</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->no_hp_ayah }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Ibu</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->nama_ibu }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Pekerjaan Ibu</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->pekerjaan_ibu }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">No. HP Ibu</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->no_hp_ibu }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Alamat Orang Tua</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $ppdb->alamat_ortu }}</dd>
                            </div>
                        </dl>
                    </div>

                    @if($ppdb->status == 'Diterima')
                    <div class="bg-green-50 border border-green-200 rounded-md p-4">
                        <h3 class="text-lg font-medium text-green-800 mb-2">Selamat! Anda Diterima</h3>
                        <p class="text-green-700 mb-4">Silakan lakukan daftar ulang dengan membawa dokumen asli ke sekolah pada tanggal yang telah ditentukan.</p>
                        <div class="space-y-2">
                            <p class="text-sm text-green-600"><strong>Tanggal Daftar Ulang:</strong> 11 - 15 Juli 2024</p>
                            <p class="text-sm text-green-600"><strong>Waktu:</strong> 08:00 - 15:00 WIB</p>
                            <p class="text-sm text-green-600"><strong>Tempat:</strong> Ruang PPDB SMK Negeri 1 Jakarta</p>
                        </div>
                    </div>
                    @elseif($ppdb->status == 'Ditolak')
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <h3 class="text-lg font-medium text-red-800 mb-2">Mohon Maaf</h3>
                        <p class="text-red-700">Pendaftaran Anda tidak dapat diproses. Silakan hubungi panitia PPDB untuk informasi lebih lanjut atau mencoba mendaftar kembali pada gelombang berikutnya.</p>
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
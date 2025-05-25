@extends('layouts.app')

@section('title', 'Form Pendaftaran PPDB')
@section('meta_description', 'Form pendaftaran PPDB tahun ajaran 2024/2025')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Form Pendaftaran PPDB</h1>
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('web.ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Data Pribadi -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Pribadi</h2>
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                        <select name="agama" id="agama" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                </div>

                <!-- Data Sekolah -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Sekolah</h2>
                    
                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="tahun_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" id="tahun_lulus" value="{{ old('tahun_lulus') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="jurusan_id" class="block text-sm font-medium text-gray-700">Pilihan Jurusan</label>
                        <select name="jurusan_id" id="jurusan_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusan as $item)
                            <option value="{{ $item->id }}" {{ old('jurusan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Orang Tua</h2>
                    
                    <div>
                        <label for="nama_ortu" class="block text-sm font-medium text-gray-700">Nama Orang Tua/Wali</label>
                        <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="pekerjaan_ortu" class="block text-sm font-medium text-gray-700">Pekerjaan Orang Tua/Wali</label>
                        <input type="text" name="pekerjaan_ortu" id="pekerjaan_ortu" value="{{ old('pekerjaan_ortu') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP (WhatsApp)</label>
                        <input type="tel" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Upload Dokumen</h2>
                    
                    <div>
                        <label for="ijazah" class="block text-sm font-medium text-gray-700">Ijazah/SKL (PDF)</label>
                        <input type="file" name="ijazah" id="ijazah" accept=".pdf" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    </div>

                    <div>
                        <label for="skhun" class="block text-sm font-medium text-gray-700">SKHUN (PDF)</label>
                        <input type="file" name="skhun" id="skhun" accept=".pdf" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    </div>

                    <div>
                        <label for="kk" class="block text-sm font-medium text-gray-700">Kartu Keluarga (PDF)</label>
                        <input type="file" name="kk" id="kk" accept=".pdf" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    </div>

                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Pas Foto 3x4 (JPG/PNG)</label>
                        <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" required
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('web.ppdb.index') }}" class="text-primary-600 hover:text-primary-500">
                        Kembali ke Halaman PPDB
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
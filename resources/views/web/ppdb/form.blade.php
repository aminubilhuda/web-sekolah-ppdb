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
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Aminu Bil Huda">
                    </div>

                    <div>
                        <div class="flex justify-between items-center">
                            <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
                            <button type="button" onclick="openNisnModal()" class="text-sm text-primary-600 hover:text-primary-700">
                                Lupa NISN?
                            </button>
                        </div>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 1234567890">
                    </div>

                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 3523020101900001">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Contoh: Tuban">
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Jl. Merdeka No. 123, RT 001/RW 002, Kel. Tuban, Kec. Tuban, Tuban">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <input type="tel" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <!-- Data Sekolah -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Sekolah</h2>
                    
                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: SMP Negeri 1 Tuban">
                    </div>

                    <div>
                        <label for="tahun_lulus" class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" value="{{ old('tahun_lulus') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 2024">
                    </div>

                    <div>
                        <label for="jurusan_pilihan" class="block text-sm font-medium text-gray-700">Jurusan Pilihan</label>
                        <select name="jurusan_pilihan" id="jurusan_pilihan" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_pilihan') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Ayah</h2>
                    
                    <div>
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Budi Santoso">
                    </div>

                    <div>
                        <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Wiraswasta">
                    </div>

                    <div>
                        <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700">Nomor HP Ayah</label>
                        <input type="tel" name="no_hp_ayah" id="no_hp_ayah" value="{{ old('no_hp_ayah') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Data Ibu</h2>
                    
                    <div>
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Siti Aminah">
                    </div>

                    <div>
                        <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Ibu Rumah Tangga">
                    </div>

                    <div>
                        <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700">Nomor HP Ibu</label>
                        <input type="tel" name="no_hp_ibu" id="no_hp_ibu" value="{{ old('no_hp_ibu') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Alamat Orang Tua</h2>
                    
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="alamat_sama" name="alamat_sama" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="alamat_sama" class="ml-2 block text-sm text-gray-700">
                            Alamat sama dengan alamat siswa
                        </label>
                    </div>
                    
                    <div>
                        <label for="alamat_ortu" class="block text-sm font-medium text-gray-700">Alamat Lengkap Orang Tua</label>
                        <textarea name="alamat_ortu" id="alamat_ortu" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Contoh: Jl. Merdeka No. 123, RT 001/RW 002, Kel. Tuban, Kec. Tuban, Tuban">{{ old('alamat_ortu') }}</textarea>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900">Upload Dokumen (Opsional)</h2>
                    <p class="text-sm text-gray-500 mb-4">Dokumen dapat diunggah nanti saat daftar ulang</p>
                    
                    <div>
                        <label for="foto" class="block text-sm font-medium text-gray-700">Foto 3x4</label>
                        <input type="file" name="foto" id="foto" accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                    </div>

                    <div>
                        <label for="ijazah" class="block text-sm font-medium text-gray-700">Ijazah/SKL</label>
                        <input type="file" name="ijazah" id="ijazah" accept=".pdf"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="mt-1 text-sm text-gray-500">Format: PDF. Maksimal 2MB</p>
                    </div>

                    <div>
                        <label for="kk" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                        <input type="file" name="kk" id="kk" accept=".pdf"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        <p class="mt-1 text-sm text-gray-500">Format: PDF. Maksimal 2MB</p>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal NISN -->
<div id="nisnModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" style="z-index: 50;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[80vh] relative">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Cari NISN</h3>
                <button type="button" onclick="closeNisnModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Tutup</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-4 h-[calc(80vh-4rem)]">
                <iframe src="https://nisn.data.kemdikbud.go.id/index.php/Cindex/formcaribynama" 
                    class="w-full h-full border-0" 
                    frameborder="0">
                </iframe>
            </div>
        </div>
    </div>
</div>

<script>
function openNisnModal() {
    document.getElementById('nisnModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeNisnModal() {
    document.getElementById('nisnModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('nisnModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeNisnModal();
    }
});

// Fungsi untuk menangani checkbox alamat sama
document.getElementById('alamat_sama').addEventListener('change', function() {
    const alamatSiswa = document.getElementById('alamat').value;
    const alamatOrtu = document.getElementById('alamat_ortu');
    
    if (this.checked) {
        alamatOrtu.value = alamatSiswa;
        alamatOrtu.readOnly = true;
    } else {
        alamatOrtu.value = '';
        alamatOrtu.readOnly = false;
    }
});

// Update alamat orang tua jika alamat siswa berubah dan checkbox dicentang
document.getElementById('alamat').addEventListener('input', function() {
    const checkbox = document.getElementById('alamat_sama');
    if (checkbox.checked) {
        document.getElementById('alamat_ortu').value = this.value;
    }
});
</script>
@endsection 
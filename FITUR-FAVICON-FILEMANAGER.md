# Implementasi Favicon Dinamis dan File Manager

## 📋 Ringkasan Fitur

Telah berhasil diimplementasikan dua fitur utama:

1. **Favicon Dinamis** - Icon yang diupload di profil sekolah akan otomatis menggantikan favicon default
2. **File Manager** - Menu di dashboard Filament untuk mengelola dan menghapus file-file yang sudah diupload

## 🎯 Fitur Favicon Dinamis

### Implementasi

-   **File yang dimodifikasi**: `resources/views/layouts/app.blade.php`
-   **Logika**: Menggunakan favicon dari ProfilSekolah jika tersedia, jika tidak menggunakan favicon default

### Kode yang ditambahkan:

```php
<!-- Favicon -->
@php
    $profil = app('profil_sekolah');
@endphp
@if($profil && $profil->favicon)
    <link rel="icon" type="image/x-icon" href="{{ $profil->favicon_url }}">
@else
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
@endif
```

### Cara Kerja:

1. Sistem mengambil data profil sekolah dari cache/singleton
2. Jika profil sekolah memiliki favicon, gunakan favicon tersebut
3. Jika tidak ada favicon di profil sekolah, gunakan favicon default (`favicon.ico`)

## 📁 Fitur File Manager

### Lokasi File:

-   **Resource**: `app/Filament/Resources/FileManagerResource.php`
-   **Page**: `app/Filament/Resources/FileManagerResource/Pages/ListFileManager.php`
-   **Views**:
    -   `resources/views/filament/pages/file-manager-info.blade.php`
    -   `resources/views/filament/pages/storage-info.blade.php`

### Fitur yang Tersedia:

#### 1. **Tampilan File**

-   Menampilkan semua file di `storage/app/public/`
-   Kolom: Nama File, Tipe, Ukuran, Terakhir Diubah, Direktori
-   Pagination dan sorting
-   Badge warna untuk tipe file yang berbeda

#### 2. **Filter**

-   Filter berdasarkan tipe file (JPG, PNG, PDF, DOC, dll)
-   Filter file lama (>30 hari)

#### 3. **Aksi Individual**

-   **Preview**: Melihat file gambar dan PDF di browser baru
-   **Download**: Mengunduh file ke komputer
-   **Hapus**: Menghapus file individual dengan konfirmasi

#### 4. **Aksi Bulk**

-   **Hapus File Terpilih**: Menghapus multiple file sekaligus
-   **Hapus File Lama**: Menghapus semua file yang lebih lama dari 30 hari

#### 5. **Header Actions**

-   **Refresh**: Memuat ulang daftar file
-   **Info Upload**: Modal informasi tentang file manager
-   **Info Storage**: Modal statistik storage (total file, ukuran, distribusi tipe)

### Struktur Direktori yang Dikelola:

```
storage/app/public/
├── profil/ (Logo, favicon, banner sekolah)
├── berita/ (Gambar berita)
├── galeri/ (Foto galeri)
├── slider/ (Gambar slider)
└── uploads/ (File upload lainnya)
```

## 🔧 Konfigurasi

### Navigation

-   **Group**: Sistem
-   **Sort Order**: 99 (paling bawah)
-   **Icon**: heroicon-o-folder
-   **Label**: File Manager

### Permissions

-   **Create**: Disabled
-   **Edit**: Disabled
-   **Delete**: Enabled
-   **Bulk Delete**: Enabled

## 📊 Statistik Storage

File Manager menyediakan informasi statistik:

-   Total jumlah file
-   Total ukuran storage
-   Total folder
-   Distribusi tipe file
-   Tips optimasi storage

## ⚠️ Peringatan Keamanan

1. **File yang dihapus tidak dapat dikembalikan**
2. **Pastikan file tidak sedang digunakan sebelum menghapus**
3. **Lakukan backup file penting secara teratur**
4. **Gunakan fitur bulk delete dengan hati-hati**

## 🚀 Cara Menggunakan

### Mengakses File Manager:

1. Login ke dashboard admin Filament
2. Navigasi ke menu "Sistem" → "File Manager"
3. Gunakan filter untuk mencari file tertentu
4. Gunakan aksi sesuai kebutuhan

### Mengganti Favicon:

1. Login ke dashboard admin Filament
2. Navigasi ke "Profil Sekolah"
3. Upload favicon baru di field "Favicon"
4. Simpan perubahan
5. Favicon akan otomatis berubah di website

## 🔍 Troubleshooting

### Jika favicon tidak berubah:

1. Clear cache browser
2. Pastikan file favicon sudah terupload dengan benar
3. Cek permission file storage
4. Restart server jika diperlukan

### Jika file manager tidak menampilkan file:

1. Pastikan direktori `storage/app/public` ada
2. Cek permission direktori storage
3. Jalankan `php artisan storage:link` jika diperlukan

## 📝 Catatan Teknis

-   File Manager menggunakan custom pagination karena tidak menggunakan Eloquent model
-   Favicon dinamis menggunakan singleton pattern untuk performa optimal
-   Semua operasi file menggunakan Laravel Storage facade untuk keamanan
-   File Manager kompatibel dengan Windows dan Linux path separator

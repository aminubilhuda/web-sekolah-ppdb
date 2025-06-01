# Solusi Masalah CSS Hilang Setelah npm run build

## Masalah

Ketika menjalankan `npm run dev` tampilan website bagus sesuai dengan stylenya, tetapi ketika menjalankan `npm run build` tampilan seperti tidak ada stylenya.

## Penyebab Utama

1. **File `public/hot` masih ada** - Laravel mengira Vite dev server masih berjalan
2. **Tailwind CSS purging terlalu agresif** - Class yang digunakan dinamis terhapus
3. **Cache browser atau Laravel** - Asset lama masih di-cache
4. **Konfigurasi Vite tidak optimal** untuk production

## Solusi yang Sudah Diterapkan

### 1. Hapus File Hot

File `public/hot` sudah dihapus. File ini membuat Laravel mengira Vite dev server masih berjalan.

### 2. Update Tailwind Config

File `tailwind.config.js` sudah diupdate dengan:

-   Menambahkan path Filament: `"./app/Filament/**/*.php"` dan `"./vendor/filament/**/*.blade.php"`
-   Menambahkan safelist untuk class yang sering digunakan dinamis
-   Memastikan semua component class tidak di-purge

### 3. Update Vite Config

File `vite.config.js` sudah diupdate dengan:

-   Manifest generation yang benar
-   Output directory yang tepat
-   Alias resolution untuk resources

### 4. Script Build Helper

File `build-fix.bat` sudah dibuat untuk automasi rebuild.

## Langkah Manual yang Harus Dilakukan

### Langkah 1: Bersihkan Cache

```bash
# Hapus folder build lama
rmdir /s /q "public\build"

# Hapus cache Vite
rmdir /s /q "node_modules\.vite"

# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Langkah 2: Rebuild Assets

```bash
npm run build
```

### Langkah 3: Verifikasi Build

Pastikan file-file ini ada setelah build:

-   `public/build/manifest.json`
-   `public/build/assets/app-[hash].css`
-   `public/build/assets/app-[hash].js`

### Langkah 4: Test Website

1. Buka website di browser
2. Tekan Ctrl+F5 untuk hard refresh (bypass cache)
3. Periksa Network tab di DevTools untuk memastikan CSS ter-load

## Debugging Tambahan

### Cek Manifest

```bash
# Lihat isi manifest.json
type public\build\manifest.json
```

### Cek CSS Build

```bash
# Lihat beberapa baris pertama CSS
powershell -Command "Get-Content 'public/build/assets/app-*.css' | Select-Object -First 10"
```

### Cek Layout Template

Pastikan di `resources/views/layouts/app.blade.php` menggunakan:

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## Troubleshooting Lanjutan

### Jika CSS Masih Hilang:

1. **Cek Browser DevTools**:

    - Buka Network tab
    - Refresh halaman
    - Lihat apakah file CSS ter-load dengan status 200
    - Jika 404, ada masalah path
    - Jika 200 tapi kosong, ada masalah build

2. **Cek File CSS**:

    - Buka `public/build/assets/app-[hash].css`
    - Pastikan berisi class Tailwind (cari "container", "flex", "bg-", dll)
    - Jika kosong atau sangat kecil, ada masalah Tailwind purging

3. **Cek Environment**:
    - Pastikan `APP_ENV=local` di `.env`
    - Pastikan `APP_URL` sesuai dengan URL yang digunakan

### Jika Masih Bermasalah:

1. **Disable Tailwind Purging Sementara**:

    ```js
    // Di tailwind.config.js, tambahkan:
    purge: false,
    ```

2. **Gunakan CDN Tailwind Sementara**:

    ```html
    <!-- Di layout, tambahkan sebelum @vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    ```

3. **Cek Filament CSS**:
   Filament mungkin membutuhkan CSS terpisah. Pastikan Filament panel berfungsi normal.

## Catatan Penting

-   Selalu hapus file `public/hot` sebelum build production
-   Gunakan hard refresh (Ctrl+F5) untuk bypass browser cache
-   Periksa console browser untuk error JavaScript yang mungkin mempengaruhi CSS
-   Jika menggunakan server production, pastikan web server serve file static dengan benar

## Hasil yang Diharapkan

Setelah mengikuti langkah-langkah di atas:

1. Website tampil dengan styling yang benar di production build
2. File CSS ter-load dengan ukuran yang wajar (biasanya 50KB+)
3. Tidak ada error 404 untuk asset files
4. Filament admin panel tetap berfungsi normal

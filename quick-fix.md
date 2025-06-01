# Quick Fix: CSS Hilang Setelah npm run build

## Masalah Utama yang Sudah Diperbaiki ✅

1. **File `public/hot` sudah dihapus** - Ini adalah penyebab utama masalah
2. **Tailwind config sudah diupdate** - Menambahkan Filament paths dan safelist
3. **Vite config sudah dioptimasi** - Manifest dan output directory sudah benar

## Langkah Cepat yang Harus Anda Lakukan:

### 1. Jalankan Script PowerShell (Recommended)

```powershell
powershell -ExecutionPolicy Bypass -File build-fix.ps1
```

### 2. Atau Manual (Jika Script Tidak Bisa Dijalankan)

```bash
# 1. Hapus build lama
rmdir /s /q "public\build"

# 2. Build ulang
npm run build

# 3. Hard refresh browser (Ctrl+F5)
```

### 3. Verifikasi

-   Buka website
-   Tekan **Ctrl+F5** (hard refresh)
-   Cek DevTools Network tab - pastikan CSS file ter-load

## Jika Masih Bermasalah:

### Cek File CSS Build

```bash
# Lihat ukuran file CSS
dir public\build\assets\app-*.css
```

File CSS seharusnya berukuran 50KB+ (bukan beberapa KB saja)

### Temporary Fix dengan CDN

Jika masih bermasalah, tambahkan ini di `resources/views/layouts/app.blade.php` sebelum `@vite`:

```html
<script src="https://cdn.tailwindcss.com"></script>
```

### Disable Purging Sementara

Di `tailwind.config.js`, tambahkan:

```js
export default {
  content: [...],
  purge: false, // Tambahkan ini untuk disable purging
  // ... rest of config
}
```

## Status Perbaikan:

-   ✅ File hot dihapus
-   ✅ Tailwind config diupdate
-   ✅ Vite config dioptimasi
-   ✅ Build scripts dibuat
-   ⏳ Menunggu Anda jalankan rebuild

**Langkah terakhir: Jalankan `build-fix.ps1` atau rebuild manual, lalu hard refresh browser!**

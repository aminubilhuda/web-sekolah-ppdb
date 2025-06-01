Write-Host "=== Memperbaiki Masalah CSS Build ===" -ForegroundColor Green

# Langkah 1: Hapus file hot jika ada
if (Test-Path "public/hot") {
    Remove-Item "public/hot" -Force
    Write-Host "✓ File public/hot dihapus" -ForegroundColor Yellow
}

# Langkah 2: Hapus folder build lama
if (Test-Path "public/build") {
    Remove-Item "public/build" -Recurse -Force
    Write-Host "✓ Folder public/build dihapus" -ForegroundColor Yellow
}

# Langkah 3: Hapus cache Vite
if (Test-Path "node_modules/.vite") {
    Remove-Item "node_modules/.vite" -Recurse -Force
    Write-Host "✓ Cache Vite dihapus" -ForegroundColor Yellow
}

# Langkah 4: Clear Laravel cache
Write-Host "Membersihkan cache Laravel..." -ForegroundColor Blue
try {
    php artisan config:clear 2>$null
    php artisan cache:clear 2>$null
    php artisan view:clear 2>$null
    Write-Host "✓ Cache Laravel dibersihkan" -ForegroundColor Yellow
} catch {
    Write-Host "⚠ Gagal membersihkan cache Laravel (mungkin Redis tidak berjalan)" -ForegroundColor Orange
}

# Langkah 5: Rebuild assets
Write-Host "Rebuilding assets..." -ForegroundColor Blue
npm run build

# Langkah 6: Verifikasi hasil
Write-Host "`n=== Verifikasi Hasil ===" -ForegroundColor Green

if (Test-Path "public/build/manifest.json") {
    Write-Host "✓ manifest.json ada" -ForegroundColor Green
    
    # Cek file CSS
    $cssFiles = Get-ChildItem "public/build/assets/app-*.css" -ErrorAction SilentlyContinue
    if ($cssFiles) {
        $cssFile = $cssFiles[0]
        $cssSize = [math]::Round($cssFile.Length / 1KB, 2)
        Write-Host "✓ CSS file ada: $($cssFile.Name) ($cssSize KB)" -ForegroundColor Green
        
        if ($cssSize -lt 10) {
            Write-Host "⚠ CSS file terlalu kecil, mungkin ada masalah Tailwind purging" -ForegroundColor Orange
        }
    } else {
        Write-Host "✗ CSS file tidak ditemukan" -ForegroundColor Red
    }
    
    # Cek file JS
    $jsFiles = Get-ChildItem "public/build/assets/app-*.js" -ErrorAction SilentlyContinue
    if ($jsFiles) {
        $jsFile = $jsFiles[0]
        $jsSize = [math]::Round($jsFile.Length / 1KB, 2)
        Write-Host "✓ JS file ada: $($jsFile.Name) ($jsSize KB)" -ForegroundColor Green
    } else {
        Write-Host "✗ JS file tidak ditemukan" -ForegroundColor Red
    }
    
} else {
    Write-Host "✗ manifest.json tidak ditemukan - Build gagal!" -ForegroundColor Red
}

Write-Host "`n=== Langkah Selanjutnya ===" -ForegroundColor Green
Write-Host "1. Buka website di browser" -ForegroundColor White
Write-Host "2. Tekan Ctrl+F5 untuk hard refresh" -ForegroundColor White
Write-Host "3. Periksa Network tab di DevTools" -ForegroundColor White
Write-Host "4. Pastikan CSS ter-load dengan status 200" -ForegroundColor White

Write-Host "`nSelesai! Jika masih ada masalah, baca SOLUSI-BUILD-PROBLEM.md" -ForegroundColor Green 
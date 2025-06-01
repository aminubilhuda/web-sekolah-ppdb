@echo off
echo "Membersihkan cache dan build..."

REM Hapus folder build lama
if exist "public\build" rmdir /s /q "public\build"

REM Hapus node_modules/.vite jika ada
if exist "node_modules\.vite" rmdir /s /q "node_modules\.vite"

REM Clear Laravel cache (optional, mungkin error jika Redis tidak running)
php artisan config:clear 2>nul
php artisan cache:clear 2>nul
php artisan view:clear 2>nul

echo "Rebuild assets..."
npm run build

echo "Selesai! Coba akses website sekarang."
pause 
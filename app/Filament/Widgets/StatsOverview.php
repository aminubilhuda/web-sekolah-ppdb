<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Berita;
use App\Models\Prestasi;
use App\Models\Agenda;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $bulanIni = Carbon::now()->startOfMonth();
        $semesterIni = Carbon::now()->startOfMonth()->subMonths(6);
        
        return [
            Stat::make('Total Guru', Guru::where('is_active', true)->count())
                ->description('Jumlah guru aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Total Siswa', Siswa::where('is_active', true)->count())
                ->description('Jumlah siswa aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Total Jurusan', Jurusan::count())
                ->description('Jumlah jurusan')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Prestasi Semester Ini', Prestasi::where('created_at', '>=', $semesterIni)->count())
                ->description('Prestasi yang diraih semester ini')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Agenda Mendatang', Agenda::where('tanggal_mulai', '>', now())->where('is_published', true)->count())
                ->description('Agenda yang akan datang')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Berita Terbaru', Berita::where('created_at', '>=', $bulanIni)->count())
                ->description('Berita bulan ini')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary'),
        ];
    }
} 
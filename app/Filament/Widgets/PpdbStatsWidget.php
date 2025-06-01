<?php

namespace App\Filament\Widgets;

use App\Models\Ppdb;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PpdbStatsWidget extends StatsOverviewWidget
{
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $total = Ppdb::count();
        $menunggu = Ppdb::where('status', 'Menunggu')->count();
        $diterima = Ppdb::where('status', 'Diterima')->count();
        $ditolak = Ppdb::where('status', 'Ditolak')->count();

        return [
            Stat::make('Total Pendaftar', $total)
                ->description('Total semua pendaftar PPDB')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
                
            Stat::make('Menunggu Verifikasi', $menunggu)
                ->description('Pendaftar yang belum diverifikasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
                
            Stat::make('Diterima', $diterima)
                ->description($total > 0 ? 'Tingkat penerimaan ' . round(($diterima / $total) * 100, 1) . '%' : 'Belum ada data')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Ditolak', $ditolak)
                ->description($total > 0 ? 'Tingkat penolakan ' . round(($ditolak / $total) * 100, 1) . '%' : 'Belum ada data')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
} 
<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\LatestGuru;
use App\Filament\Widgets\LatestPrestasi;
use App\Filament\Widgets\SiswaChart;
use App\Filament\Widgets\PrestasiChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -2;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            SiswaChart::class,
            PrestasiChart::class,
            LatestGuru::class,
            LatestPrestasi::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|string|array
    {
        return 1;
    }
} 
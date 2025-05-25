<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Prestasi;
use Carbon\Carbon;

class PrestasiChart extends ChartWidget
{
    protected static ?string $heading = 'Prestasi 6 Bulan Terakhir';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('M Y');
        });

        $data = $months->map(function ($month) {
            return Prestasi::whereMonth('created_at', Carbon::parse($month))
                ->whereYear('created_at', Carbon::parse($month))
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Prestasi',
                    'data' => $data,
                    'borderColor' => '#10B981',
                    'tension' => 0.3,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
} 
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Siswa;
use App\Models\Prestasi;
use Carbon\Carbon;

class SiswaChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Siswa per Jurusan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $jurusan = \App\Models\Jurusan::all();
        $labels = $jurusan->pluck('nama');
        $data = $jurusan->map(function ($jur) {
            return Siswa::where('jurusan_id', $jur->id)->where('status', 'aktif')->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

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
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Siswa;
use App\Models\Jurusan;

class SiswaChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Siswa per Jurusan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $jurusan = Jurusan::all();
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
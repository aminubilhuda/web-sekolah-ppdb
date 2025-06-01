<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Siswa;
use App\Models\Jurusan;

class SiswaChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Siswa per Jurusan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $jurusan = Jurusan::all();
        $labels = [];
        $data = [];

        foreach ($jurusan as $jur) {
            $labels[] = $jur->nama;
            $data[] = Siswa::where('jurusan_id', $jur->id)->where('is_active', true)->count();
        }

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
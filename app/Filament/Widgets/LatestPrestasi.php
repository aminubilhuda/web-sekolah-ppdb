<?php

namespace App\Filament\Widgets;

use App\Models\Prestasi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestPrestasi extends BaseWidget
{
    protected static ?string $heading = 'Prestasi Terbaru';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Prestasi::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->searchable()
                    ->sortable(),
            ]);
    }
} 
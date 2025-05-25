<?php

namespace App\Filament\Widgets;

use App\Models\Guru;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestGuru extends BaseWidget
{
    protected static ?string $heading = 'Guru Terbaru';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Guru::query()
                    ->with('jurusan')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama')
                    ->searchable()
                    ->sortable(),
            ]);
    }
} 
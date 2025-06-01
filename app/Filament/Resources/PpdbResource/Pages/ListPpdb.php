<?php

namespace App\Filament\Resources\PpdbResource\Pages;

use App\Filament\Resources\PpdbResource;
use App\Filament\Widgets\PpdbStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Exports\PpdbExport;
use Maatwebsite\Excel\Facades\Excel;

class ListPpdb extends ListRecords
{
    protected static string $resource = PpdbResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pendaftar')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    return Excel::download(new PpdbExport, 'data-ppdb-' . date('Y-m-d') . '.xlsx');
                })
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PpdbStatsWidget::class,
        ];
    }
} 
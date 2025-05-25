<?php

namespace App\Filament\Resources\MitraIndustriResource\Pages;

use App\Filament\Resources\MitraIndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMitraIndustris extends ListRecords
{
    protected static string $resource = MitraIndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 
<?php

namespace App\Filament\Resources\GaleriFotoResource\Pages;

use App\Filament\Resources\GaleriFotoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGaleriFoto extends CreateRecord
{
    protected static string $resource = GaleriFotoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 
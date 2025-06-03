<?php

namespace App\Filament\Resources\FonnteSettingResource\Pages;

use App\Filament\Resources\FonnteSettingResource;
use App\Models\Setting;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Cache;
use Filament\Notifications\Notification;
use Filament\Actions\CreateAction;

class ManageFonnteSettings extends ManageRecords
{
    protected static string $resource = FonnteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pengaturan')
                ->modalHeading('Tambah Pengaturan WhatsApp')
                ->using(function (array $data): Setting {
                    return Setting::create([
                        'key' => 'fonnte_settings',
                        'group' => 'fonnte',
                        'description' => 'Pengaturan WhatsApp Fonnte',
                        'value' => $data['value']
                    ]);
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Pengaturan berhasil ditambahkan')
                        ->body('Pengaturan WhatsApp telah berhasil ditambahkan.')
                ),
        ];
    }

    protected function afterCreate(): void
    {
        // Clear cache setelah create
        Cache::forget('fonnte_settings');
    }

    protected function afterUpdate(): void
    {
        // Clear cache setelah update
        Cache::forget('fonnte_settings');
    }
} 
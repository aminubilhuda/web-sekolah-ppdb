<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use App\Imports\GuruImport;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Action;

class ImportGuru extends Page
{
    use InteractsWithForms;

    protected static string $resource = GuruResource::class;

    protected static string $view = 'filament.resources.guru-resource.pages.import-guru';

    protected static ?string $title = 'Import Data Guru';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('File Excel')
                    ->required()
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                    ->directory('imports')
                    ->preserveFilenames()
            ])
            ->statePath('data');
    }

    public function import()
    {
        $data = $this->form->getState();

        try {
            Excel::import(new GuruImport, storage_path('app/public/' . $data['file']));
            
            Notification::make()
                ->title('Import Berhasil')
                ->success()
                ->send();

            return redirect()->to(GuruResource::getUrl());
        } catch (\Exception $e) {
            Notification::make()
                ->title('Import Gagal')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadTemplate')
                ->label('Download Template Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('guru.template.download'))
                ->color('success'),
        ];
    }
} 
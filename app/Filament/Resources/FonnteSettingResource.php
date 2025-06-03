<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FonnteSettingResource\Pages;
use App\Models\Setting;
use App\Services\FonnteService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class FonnteSettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'WhatsApp';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi WhatsApp')
                    ->description('Pengaturan untuk integrasi WhatsApp menggunakan Fonnte')
                    ->schema([
                        Forms\Components\TextInput::make('value.api_key')
                            ->label('API Key')
                            ->required()
                            ->helperText('Masukkan API Key dari dashboard Fonnte'),

                        Forms\Components\TextInput::make('value.admin_number')
                            ->label('Nomor Admin')
                            ->required()
                            ->helperText('Format: 628xxxxxxxxxx')
                            ->tel(),

                        Forms\Components\TextInput::make('value.base_url')
                            ->label('Base URL')
                            ->default('https://api.fonnte.com/send')
                            ->required(),

                        Forms\Components\Toggle::make('value.is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Test Koneksi')
                    ->description('Test koneksi WhatsApp')
                    ->schema([
                        Forms\Components\TextInput::make('test_number')
                            ->label('Nomor Test')
                            ->required()
                            ->helperText('Nomor WhatsApp untuk testing')
                            ->tel(),

                        Forms\Components\Textarea::make('test_message')
                            ->label('Pesan Test')
                            ->default('Ini adalah pesan test dari sistem PPDB')
                            ->required()
                            ->rows(3),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value.admin_number')
                    ->label('Nomor Admin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value.base_url')
                    ->label('Base URL')
                    ->searchable(),
                Tables\Columns\IconColumn::make('value.is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('test_connection')
                    ->label('Test Koneksi')
                    ->icon('heroicon-o-check-circle')
                    ->form([
                        Forms\Components\TextInput::make('test_number')
                            ->label('Nomor Test')
                            ->required()
                            ->helperText('Nomor WhatsApp untuk testing')
                            ->tel(),

                        Forms\Components\Textarea::make('test_message')
                            ->label('Pesan Test')
                            ->default('Ini adalah pesan test dari sistem PPDB')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Setting $record, array $data, FonnteService $fonnteService) {
                        try {
                            $result = $fonnteService->testConnection(
                                $data['test_number'],
                                $data['test_message']
                            );

                            if ($result['success']) {
                                Notification::make()
                                    ->title('Koneksi Berhasil')
                                    ->success()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Koneksi Gagal')
                                    ->body($result['message'])
                                    ->danger()
                                    ->send();
                            }
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFonnteSettings::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('group', 'fonnte');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_fonntesetting');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_fonntesetting');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_fonntesetting');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_fonntesetting');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_fonntesetting');
    }
} 
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbInfoResource\Pages;
use App\Models\PpdbInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Traits\HasOptimizedResource;
use App\Traits\HasOptimizedFileUpload;
use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class PpdbInfoResource extends Resource
{
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

    protected static ?string $model = PpdbInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Informasi PPDB';
    protected static ?string $modelLabel = 'Informasi PPDB';
    protected static ?string $pluralModelLabel = 'Informasi PPDB';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Umum')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('gambar_background')
                            ->required()
                            ->image()
                            ->directory('ppdb/background')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('1080')
                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Panduan Pendaftaran')
                    ->schema([
                        Forms\Components\Textarea::make('panduan_pendaftaran')
                            ->label('Panduan Pendaftaran')
                            ->placeholder('Masukkan teks panduan pendaftaran')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('langkah_pendaftaran')
                            ->label('Langkah-langkah Pendaftaran')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->required()
                                    ->maxLength(255)
                            ])
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(10)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_string($state)) {
                                    $component->state(json_decode($state, true) ?? []);
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (is_array($state)) {
                                    $set('langkah_pendaftaran', array_map(function ($item) {
                                        return ['item' => $item['item']];
                                    }, $state));
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Persyaratan')
                    ->schema([
                        Forms\Components\Repeater::make('persyaratan')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->required()
                                    ->maxLength(255)
                            ])
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(10)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_string($state)) {
                                    $component->state(json_decode($state, true) ?? []);
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (is_array($state)) {
                                    $set('persyaratan', array_map(function ($item) {
                                        return ['item' => $item['item']];
                                    }, $state));
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Jadwal')
                    ->schema([
                        Forms\Components\Repeater::make('jadwal')
                            ->schema([
                                Forms\Components\TextInput::make('kegiatan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('tanggal_mulai')
                                    ->required(),
                                Forms\Components\DatePicker::make('tanggal_selesai')
                                    ->required()
                            ])
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(10)
                            ->columnSpanFull()
                            ->afterStateHydrated(function ($component, $state) {
                                if (is_string($state)) {
                                    $component->state(json_decode($state, true) ?? []);
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (is_array($state)) {
                                    $set('jadwal', array_map(function ($item) {
                                        return [
                                            'kegiatan' => $item['kegiatan'],
                                            'tanggal_mulai' => $item['tanggal_mulai'],
                                            'tanggal_selesai' => $item['tanggal_selesai']
                                        ];
                                    }, $state));
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('whatsapp')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('gambar_background')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbInfos::route('/'),
            'create' => Pages\CreatePpdbInfo::route('/create'),
            'edit' => Pages\EditPpdbInfo::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_info_ppdb');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_info_ppdb');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_info_ppdb');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_info_ppdb');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_info_ppdb');
    }
} 
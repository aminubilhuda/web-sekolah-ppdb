<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasOptimizedResource;

class AbsensiResource extends Resource
{
    use HasOptimizedResource;

    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Absensi';
    protected static ?string $modelLabel = 'Absensi';
    protected static ?string $pluralModelLabel = 'Absensi';
    protected static ?int $navigationSort = 10;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['siswa', 'guru'])
            ->withCount(['siswa', 'guru']); // Eager loading dengan count
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Absensi')
                    ->schema([
                        Forms\Components\Select::make('siswa_id')
                            ->relationship('siswa', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return Cache::remember('siswa_options', 3600, function () {
                                    return \App\Models\Siswa::where('is_active', true)
                                        ->pluck('nama', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\Select::make('guru_id')
                            ->relationship('guru', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return Cache::remember('guru_options', 3600, function () {
                                    return \App\Models\Guru::where('is_active', true)
                                        ->pluck('nama', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\DatePicker::make('tanggal')
                            ->required()
                            ->default(now())
                            ->maxDate(now()),
                        Forms\Components\Select::make('status')
                            ->options([
                                'hadir' => 'Hadir',
                                'izin' => 'Izin',
                                'sakit' => 'Sakit',
                                'alpha' => 'Alpha',
                            ])
                            ->required()
                            ->default('hadir'),
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan absensi ini?')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guru.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'izin',
                        'danger' => 'sakit',
                        'secondary' => 'alpha',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('siswa_id')
                    ->relationship('siswa', 'nama'),
                Tables\Filters\SelectFilter::make('guru_id')
                    ->relationship('guru', 'nama'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal', 'desc');
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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_absensi');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_absensi');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_absensi');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_absensi');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_absensi');
    }
} 
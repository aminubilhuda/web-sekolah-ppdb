<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasOptimizedResource;

class KelasResource extends Resource
{
    use HasOptimizedResource;

    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $modelLabel = 'Kelas';
    protected static ?string $pluralModelLabel = 'Kelas';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?int $navigationSort = 7;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['jurusan', 'guru'])
            ->withCount('siswa'); // Eager loading dengan count
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kelas')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kelas')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kelas')
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('tingkat')
                            ->options([
                                'X' => 'X',
                                'XI' => 'XI',
                                'XII' => 'XII'
                            ])
                            ->required(),
                        Forms\Components\Select::make('jurusan_id')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->searchable()
                            ->preload()
                            ->label('Jurusan')
                            ->options(function () {
                                return Cache::remember('jurusan_options', 3600, function () {
                                    return \App\Models\Jurusan::where('is_active', true)
                                        ->pluck('nama_jurusan', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\Select::make('guru_id')
                            ->relationship('guru', 'nama')
                            ->searchable()
                            ->preload()
                            ->label('Wali Kelas')
                            ->options(function () {
                                return Cache::remember('guru_options', 3600, function () {
                                    return \App\Models\Guru::where('is_active', true)
                                        ->pluck('nama', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\Textarea::make('deskripsi')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Kelas'),
                Tables\Columns\TextColumn::make('tingkat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->searchable()
                    ->sortable()
                    ->label('Jurusan'),
                Tables\Columns\TextColumn::make('guru.nama')
                    ->searchable()
                    ->sortable()
                    ->label('Wali Kelas'),
                Tables\Columns\TextColumn::make('siswa_count')
                    ->label('Jumlah Siswa')
                    ->counts('siswa')
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('tingkat')
                    ->options([
                        'X' => 'X',
                        'XI' => 'XI',
                        'XII' => 'XII'
                    ]),
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('jurusan', 'nama_jurusan'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama_kelas', 'asc');
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
} 
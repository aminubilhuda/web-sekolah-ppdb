<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NilaiResource\Pages;
use App\Models\Nilai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasOptimizedResource;

class NilaiResource extends Resource
{
    use HasOptimizedResource;

    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Nilai';
    protected static ?string $modelLabel = 'Nilai';
    protected static ?string $pluralModelLabel = 'Nilai';
    protected static ?int $navigationSort = 9;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['siswa', 'mapel']); // Eager loading tanpa guru
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Nilai')
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
                        Forms\Components\Select::make('mapel_id')
                            ->relationship('mapel', 'nama_mapel')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return Cache::remember('mapel_options', 3600, function () {
                                    return \App\Models\Mapel::where('is_active', true)
                                        ->pluck('nama_mapel', 'id')
                                        ->toArray();
                                });
                            }),
                        Forms\Components\TextInput::make('nilai_angka')
                            ->label('Nilai')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100),
                        Forms\Components\TextInput::make('semester')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tahun_ajaran')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kurikulum')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan nilai ini?')
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
                Tables\Columns\TextColumn::make('mapel.nama_mapel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_angka')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kurikulum')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('mapel_id')
                    ->relationship('mapel', 'nama_mapel'),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
} 
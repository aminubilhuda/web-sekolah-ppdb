<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Models\Alumni;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Alumni';
    protected static ?string $modelLabel = 'Alumni';
    protected static ?string $pluralModelLabel = 'Alumni';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['jurusan']); // Eager loading untuk relasi jurusan
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nis')
                            ->label('NIS')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->nullable(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->nullable(),
                        Forms\Components\TextInput::make('agama')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->nullable()
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->nullable()
                            ->directory('alumni')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Akademik')
                    ->schema([
                        Forms\Components\Select::make('jurusan_id')
                            ->label('Jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('tahun_lulus')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y')),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pekerjaan')
                    ->schema([
                        Forms\Components\Toggle::make('status_bekerja')
                            ->label('Sedang Bekerja')
                            ->default(false),
                        Forms\Components\TextInput::make('nama_perusahaan')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jabatan')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat_perusahaan')
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Kuliah')
                    ->schema([
                        Forms\Components\Toggle::make('status_kuliah')
                            ->label('Sedang Kuliah')
                            ->default(false),
                        Forms\Components\TextInput::make('nama_kampus')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('jurusan_kuliah')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tahun_masuk')
                            ->nullable()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y')),
                    ])->columns(2),

                Forms\Components\Section::make('Testimoni')
                    ->schema([
                        Forms\Components\Textarea::make('testimoni')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_lulus')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_bekerja')
                    ->label('Bekerja')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status_kuliah')
                    ->label('Kuliah')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('jurusan', 'nama_jurusan'),
                Tables\Filters\Filter::make('status_bekerja')
                    ->label('Bekerja')
                    ->query(fn (Builder $query): Builder => $query->where('status_bekerja', true)),
                Tables\Filters\Filter::make('status_kuliah')
                    ->label('Kuliah')
                    ->query(fn (Builder $query): Builder => $query->where('status_kuliah', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }
} 
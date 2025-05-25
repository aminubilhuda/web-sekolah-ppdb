<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Siswa';

    protected static ?string $pluralModelLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nis')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('nisn')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('nik')
                            ->maxLength(16)
                            ->nullable(),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->nullable(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan'
                            ])
                            ->nullable(),
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu'
                            ])
                            ->nullable(),
                        Forms\Components\Textarea::make('alamat')
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kelas')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jurusan_id')
                            ->label('Jurusan')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Ayah')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('nik_ayah')
                            ->maxLength(16)
                            ->nullable(),
                        Forms\Components\TextInput::make('pekerjaan_ayah')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('no_hp_ayah')
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Ibu')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ibu')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('nik_ibu')
                            ->maxLength(16)
                            ->nullable(),
                        Forms\Components\TextInput::make('pekerjaan_ibu')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('no_hp_ibu')
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Wali')
                    ->schema([
                        Forms\Components\TextInput::make('nama_wali')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('nik_wali')
                            ->maxLength(16)
                            ->nullable(),
                        Forms\Components\TextInput::make('pekerjaan_wali')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('no_hp_wali')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('hubungan_wali')
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Tambahan')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('siswa')
                            ->nullable(),
                        Forms\Components\Toggle::make('status')
                            ->required()
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('nis'),
                Tables\Columns\TextColumn::make('kelas'),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')->label('Jurusan'),
                Tables\Columns\ImageColumn::make('foto'),
                Tables\Columns\BooleanColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSiswa::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
} 
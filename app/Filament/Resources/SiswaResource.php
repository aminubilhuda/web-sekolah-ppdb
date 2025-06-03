<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use App\Services\FileUploadService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasOptimizedResource;
use App\Traits\HasOptimizedFileUpload;

class SiswaResource extends Resource
{
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $modelLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    protected static ?int $navigationSort = 6;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['jurusan', 'kelas']); // Eager loading
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

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
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nisn')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('nik')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('tempat_lahir')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_lahir')
                            ->required(),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan'
                            ])
                            ->required(),
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu'
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('no_hp')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Data Akademik')
                    ->schema([
                        Forms\Components\Select::make('jurusan_id')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('kelas_id')
                            ->relationship('kelas', 'nama_kelas')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('tahun_masuk')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y')),
                    ])->columns(2),

                Forms\Components\Section::make('Data Orang Tua')
                    ->schema([
                        Forms\Components\TextInput::make('nama_ayah')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_ayah')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('pekerjaan_ayah')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_ayah')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('nama_ibu')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_ibu')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('pekerjaan_ibu')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_ibu')
                            ->tel()
                            ->maxLength(20),
                    ])->columns(2),

                Forms\Components\Section::make('Data Wali')
                    ->schema([
                        Forms\Components\TextInput::make('nama_wali')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nik_wali')
                            ->maxLength(16),
                        Forms\Components\TextInput::make('pekerjaan_wali')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp_wali')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('hubungan_wali')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Foto & Status')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('siswa')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeTargetHeight('500')
                            ->label('Foto')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan siswa ini?')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->square(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ]),
                Tables\Filters\SelectFilter::make('agama')
                    ->options([
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Buddha' => 'Buddha',
                        'Konghucu' => 'Konghucu'
                    ]),
                Tables\Filters\SelectFilter::make('jurusan')
                    ->relationship('jurusan', 'nama_jurusan'),
                Tables\Filters\SelectFilter::make('kelas')
                    ->relationship('kelas', 'nama_kelas'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Siswa $record) {
                        $fileUploadService = app(FileUploadService::class);
                        $fileUploadService->deleteWithSizes($record->foto);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            $fileUploadService = app(FileUploadService::class);
                            foreach ($records as $record) {
                                $fileUploadService->deleteWithSizes($record->foto);
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
} 
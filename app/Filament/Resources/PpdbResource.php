<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbResource\Pages;
use App\Models\Ppdb;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PpdbResource extends Resource
{
    protected static ?string $model = Ppdb::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'PPDB';

    protected static ?string $modelLabel = 'PPDB';

    protected static ?string $pluralModelLabel = 'PPDB';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),
                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\Select::make('agama')
                    ->label('Agama')
                    ->options([
                        'Islam' => 'Islam',
                        'Kristen' => 'Kristen',
                        'Katolik' => 'Katolik',
                        'Hindu' => 'Hindu',
                        'Buddha' => 'Buddha',
                        'Konghucu' => 'Konghucu',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama_ortu')
                    ->label('Nama Orang Tua/Wali')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->label('Nomor HP')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jurusan_pilihan')
                    ->label('Jurusan Pilihan')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto')
                    ->image()
                    ->directory('ppdb/foto')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->imagePreviewHeight('250')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('ijazah')
                    ->label('Ijazah')
                    ->directory('ppdb/ijazah')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('kk')
                    ->label('Kartu Keluarga')
                    ->directory('ppdb/kk')
                    ->disk('public')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->default('Menunggu'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan Pilihan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPpdb::route('/'),
            'create' => Pages\CreatePpdb::route('/create'),
            'edit' => Pages\EditPpdb::route('/{record}/edit'),
        ];
    }
} 
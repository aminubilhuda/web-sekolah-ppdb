<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilSekolahResource\Pages;
use App\Models\ProfilSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahResource extends Resource
{
    protected static ?string $model = ProfilSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Profil Sekolah';

    protected static ?string $modelLabel = 'Profil Sekolah';

    protected static ?string $pluralModelLabel = 'Profil Sekolah';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\TextInput::make('nama_sekolah')
                            ->label('Nama Sekolah')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', \Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->hidden(),
                        Forms\Components\TextInput::make('npsn')
                            ->label('NPSN')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'swasta' => 'Swasta',
                                'negeri' => 'Negeri'
                            ])
                            ->required(),
                        Forms\Components\Select::make('jenis')
                            ->label('Jenis')
                            ->options([
                                'tk' => 'TK',
                                'sd' => 'SD',
                                'smp' => 'SMP',
                                'sma' => 'SMA',
                                'smk' => 'SMK',
                                'ma' => 'MA'
                            ])
                            ->required(),
                        Forms\Components\Select::make('status_akreditasi')
                            ->label('Status Akreditasi')
                            ->options([
                                'a' => 'A',
                                'b' => 'B',
                                'c' => 'C'
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No HP')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('provinsi')
                            ->label('Provinsi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kabupaten')
                            ->label('Kabupaten')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('lokasi_maps')
                            ->label('Lokasi Maps')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sk_pendirian')
                            ->label('SK Pendirian')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sk_izin_operasional')
                            ->label('SK Izin Operasional')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kepala_sekolah')
                            ->label('Kepala Sekolah')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('sambutan_kepala')
                            ->label('Sambutan Kepala Sekolah')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('video_profile')
                            ->label('Video Profile')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('visi')
                            ->label('Visi')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('misi')
                            ->label('Misi')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->required()
                            ->directory('profil/logo')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->required()
                            ->directory('profil/favicon')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('banner_highlight')
                            ->label('Banner Highlight')
                            ->image()
                            ->nullable()
                            ->directory('profil/banner')
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('twitter')
                            ->label('Twitter')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('youtube')
                            ->label('Youtube')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tiktok')
                            ->label('TikTok')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telegram')
                            ->label('Telegram')
                            ->nullable()
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'negeri' => 'success',
                        'swasta' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge(),
                Tables\Columns\TextColumn::make('status_akreditasi')
                    ->label('Status Akreditasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'a' => 'success',
                        'b' => 'warning',
                        'c' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('kepala_sekolah')
                    ->label('Kepala Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No HP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
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
            'index' => Pages\ListProfilSekolah::route('/'),
            'create' => Pages\CreateProfilSekolah::route('/create'),
            'edit' => Pages\EditProfilSekolah::route('/{record}/edit'),
        ];
    }
} 
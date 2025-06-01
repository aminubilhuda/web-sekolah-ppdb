<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfilSekolahResource\Pages;
use App\Models\ProfilSekolah;
use App\Services\FileUploadService;
use App\Traits\HasOptimizedResource;
use App\Traits\HasOptimizedFileUpload;
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
    use HasOptimizedResource;
    use HasOptimizedFileUpload;

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
                        Forms\Components\RichEditor::make('sejarah')
                            ->label('Sejarah')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ]),
                        Forms\Components\TextInput::make('video_profile')
                            ->label('Video Profile')
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('visi')
                            ->label('Visi')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ]),
                        Forms\Components\RichEditor::make('misi')
                            ->label('Misi')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->required()
                            ->image()
                            ->directory('profil')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200'),
                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon')
                            ->required()
                            ->image()
                            ->directory('profil/favicon')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('32')
                            ->imageResizeTargetHeight('32'),
                        Forms\Components\FileUpload::make('banner_highlight')
                            ->label('Banner Highlight')
                            ->required()
                            ->image()
                            ->directory('profil/banner')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('600'),
                        Forms\Components\FileUpload::make('gedung_image')
                            ->label('Gedung Image')
                            ->required()
                            ->image()
                            ->directory('profil/gedung')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('4:3')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600'),
                    ])->columns(2),

                Forms\Components\Section::make('Social Media')
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
        return parent::table($table)
            ->columns([
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_akreditasi')
                    ->label('Status Akreditasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepala_sekolah')
                    ->label('Kepala Sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
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
        return [];
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
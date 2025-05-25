<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GaleriResource\Pages;
use App\Models\Galeri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class GaleriResource extends Resource
{
    protected static ?string $model = Galeri::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Galeri')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan judul galeri'),
                        Forms\Components\Textarea::make('deskripsi')
                            ->maxLength(65535)
                            ->placeholder('Masukkan deskripsi galeri')
                            ->columnSpanFull(),
                    ])->columns(1),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\Select::make('jenis')
                            ->required()
                            ->options([
                                'foto' => 'Foto',
                                'video' => 'Video'
                            ])
                            ->default('foto')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state === 'foto') {
                                    $set('url_video', null);
                                } else {
                                    $set('gambar', null);
                                }
                            }),
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->directory('galeri')
                            ->visible(fn (Forms\Get $get) => $get('jenis') === 'foto')
                            ->columnSpanFull()
                            ->helperText('Format: JPG, JPEG, PNG. Maksimal 2MB'),
                        Forms\Components\TextInput::make('url_video')
                            ->url()
                            ->placeholder('Masukkan URL video (YouTube/Vimeo)')
                            ->visible(fn (Forms\Get $get) => $get('jenis') === 'video')
                            ->columnSpanFull()
                            ->helperText('Masukkan URL video dari YouTube atau Vimeo'),
                    ])->columns(1),

                Forms\Components\Section::make('Multiple Foto')
                    ->schema([
                        Forms\Components\Repeater::make('foto')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('gambar')
                                    ->required()
                                    ->image()
                                    ->directory('galeri/foto')
                                    ->columnSpanFull()
                                    ->helperText('Format: JPG, JPEG, PNG. Maksimal 2MB'),
                                Forms\Components\TextInput::make('urutan')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Urutan tampilan foto (0 = pertama)'),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => isset($state['gambar']) ? 'Foto ' . ($state['urutan'] ?? 0) : null)
                            ->visible(fn (Forms\Get $get) => $get('jenis') === 'foto')
                    ])->columns(1),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('status')
                            ->required()
                            ->default(true)
                            ->label('Status Aktif')
                            ->helperText('Aktifkan untuk menampilkan galeri di website'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('gambar')
                    ->square()
                    ->visible(fn ($record) => $record && $record->jenis === 'foto'),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'foto' => 'success',
                        'video' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('foto_count')
                    ->label('Jumlah Foto')
                    ->counts('foto')
                    ->visible(fn ($record) => $record && $record->jenis === 'foto'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'foto' => 'Foto',
                        'video' => 'Video'
                    ]),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
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
            'index' => Pages\ListGaleris::route('/'),
            'create' => Pages\CreateGaleri::route('/create'),
            'edit' => Pages\EditGaleri::route('/{record}/edit'),
        ];
    }
} 
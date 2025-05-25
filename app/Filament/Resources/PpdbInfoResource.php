<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpdbInfoResource\Pages;
use App\Models\PpdbInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PpdbInfoResource extends Resource
{
    protected static ?string $model = PpdbInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Informasi PPDB';
    protected static ?string $modelLabel = 'Informasi PPDB';
    protected static ?string $pluralModelLabel = 'Informasi PPDB';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Informasi Umum')
                            ->schema([
                                Forms\Components\TextInput::make('judul')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('subtitle')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('gambar_background')
                                    ->image()
                                    ->required()
                                    ->directory('ppdb')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make('Kontak')
                            ->schema([
                                Forms\Components\TextInput::make('telepon')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('whatsapp')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columnSpan(1),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Persyaratan')
                            ->schema([
                                Forms\Components\Repeater::make('persyaratan')
                                    ->schema([
                                        Forms\Components\TextInput::make('item')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->defaultItems(4)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make('Jadwal')
                            ->schema([
                                Forms\Components\Repeater::make('jadwal')
                                    ->schema([
                                        Forms\Components\TextInput::make('kegiatan')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('tanggal_mulai')
                                            ->required(),
                                        Forms\Components\DatePicker::make('tanggal_selesai')
                                            ->required(),
                                    ])
                                    ->defaultItems(4)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('gambar_background'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPpdbInfos::route('/'),
            'create' => Pages\CreatePpdbInfo::route('/create'),
            'edit' => Pages\EditPpdbInfo::route('/{record}/edit'),
        ];
    }
} 
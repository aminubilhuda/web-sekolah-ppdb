<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KontakResource\Pages;
use App\Models\Kontak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasOptimizedResource;

class KontakResource extends Resource
{
    use HasOptimizedResource;

    protected static ?string $model = Kontak::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'Kontak';
    protected static ?string $modelLabel = 'Kontak';
    protected static ?string $pluralModelLabel = 'Kontak';
    protected static ?string $navigationGroup = 'Pengaturan & Profil';
    protected static ?int $navigationSort = 23;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('telepon')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('subjek')
                            ->label('Subjek')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('pesan')
                            ->label('Pesan')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Status & Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'baru' => 'Baru',
                                'dibaca' => 'Dibaca', 
                                'diproses' => 'Diproses',
                                'selesai' => 'Selesai'
                            ])
                            ->default('baru'),
                        Forms\Components\Select::make('admin_id')
                            ->label('Admin')
                            ->relationship('admin', 'name')
                            ->preload()
                            ->searchable()
                            ->options(function () {
                                return Cache::remember('admin_options', 3600, function () {
                                    return \App\Models\User::pluck('name', 'id')->toArray();
                                });
                            }),
                        Forms\Components\Toggle::make('is_read')
                            ->label('Sudah Dibaca')
                            ->helperText('Apakah pesan sudah dibaca?')
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca', 
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai'
                    ]),
                Tables\Columns\TextColumn::make('admin.name')
                    ->label('Admin')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Sudah Dibaca')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca', 
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai'
                    ]),
                Tables\Filters\SelectFilter::make('admin')
                    ->relationship('admin', 'name'),
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Sudah Dibaca'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
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
            'index' => Pages\ListKontak::route('/'),
            'create' => Pages\CreateKontak::route('/create'),
            'edit' => Pages\EditKontak::route('/{record}/edit'),
        ];
    }
} 
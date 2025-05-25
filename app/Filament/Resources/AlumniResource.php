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
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_lulus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Textarea::make('testimoni')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('tempat_kerja')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->nullable()
                    ->directory('alumni')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_lulus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_kerja')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->circular(),
                Tables\Columns\BooleanColumn::make('status'),
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
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileManagerResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class FileManagerResource extends Resource
{
    protected static ?string $model = \App\Models\User::class; // Dummy model

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'File Manager';
    protected static ?string $modelLabel = 'File Manager';
    protected static ?string $pluralModelLabel = 'File Manager';
    protected static ?int $navigationSort = 99;
    protected static ?string $navigationGroup = 'Sistem';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return \App\Models\User::query();
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama File')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'jpg', 'jpeg', 'png', 'gif', 'webp' => 'success',
                        'pdf' => 'danger',
                        'doc', 'docx' => 'info',
                        'mp4', 'avi', 'mov' => 'warning',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('size')
                    ->label('Ukuran')
                    ->formatStateUsing(fn ($state) => $state ? self::formatBytes($state) : '0 B'),
                
                Tables\Columns\TextColumn::make('modified')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe File')
                    ->options([
                        'jpg' => 'JPG',
                        'jpeg' => 'JPEG', 
                        'png' => 'PNG',
                        'pdf' => 'PDF',
                        'doc' => 'DOC',
                        'docx' => 'DOCX',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_url')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => Storage::url($record->email ?? ''))
                    ->openUrlInNewTab(),
                
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($record) {
                        $filePath = $record->email; // Path stored in email field
                        $fileName = $record->name;
                        
                        if (!$filePath) {
                            Notification::make()
                                ->title('Error')
                                ->body('File path tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        $fullPath = storage_path('app/public/' . $filePath);
                        
                        if (!file_exists($fullPath)) {
                            Notification::make()
                                ->title('File tidak ditemukan')
                                ->body('File tidak dapat ditemukan di server')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        return response()->download($fullPath, $fileName);
                    }),
                
                Tables\Actions\Action::make('delete')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus File')
                    ->modalDescription(fn ($record) => 'Apakah Anda yakin ingin menghapus file "' . $record->name . '"?')
                    ->action(function ($record) {
                        $filePath = $record->email; // Path stored in email field
                        $fileName = $record->name;
                        
                        if (!$filePath) {
                            Notification::make()
                                ->title('Error')
                                ->body('File path tidak ditemukan')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        try {
                            if (Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                                
                                Notification::make()
                                    ->title('Berhasil')
                                    ->body('File "' . $fileName . '" berhasil dihapus')
                                    ->success()
                                    ->send();
                                    
                                return redirect()->route('filament.abdira.resources.file-managers.index');
                            } else {
                                Notification::make()
                                    ->title('File tidak ditemukan')
                                    ->body('File tidak dapat ditemukan')
                                    ->warning()
                                    ->send();
                            }
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('Gagal menghapus file: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('delete_selected')
                    ->label('Hapus Terpilih')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $deleted = 0;
                        foreach ($records as $record) {
                            $filePath = $record->email;
                            if ($filePath && Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                                $deleted++;
                            }
                        }
                        
                        Notification::make()
                            ->title('Berhasil')
                            ->body("$deleted file berhasil dihapus")
                            ->success()
                            ->send();
                    }),
            ])
            ->defaultSort('modified', 'desc')
            ->emptyStateHeading('Tidak ada file')
            ->emptyStateDescription('Belum ada file yang diupload')
            ->emptyStateIcon('heroicon-o-folder');
    }

    protected static function formatBytes($bytes, $precision = 2)
    {
        if (!is_numeric($bytes) || $bytes <= 0) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFileManager::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }
} 
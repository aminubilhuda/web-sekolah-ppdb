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
use Illuminate\Support\Collection;

class FileManagerResource extends Resource
{
    protected static ?string $model = \App\Models\User::class;

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
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama File')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Path')
                    ->searchable(),
                
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
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('test_action')
                    ->label('Test')
                    ->icon('heroicon-o-bug-ant')
                    ->color('warning')
                    ->action(function () {
                        \Log::info('Test action called successfully!');
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Test Berhasil!')
                            ->body('Action callback berhasil dipanggil! Sistem bekerja dengan baik.')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('view_file')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => Storage::disk('public')->url($record->email ?? ''))
                    ->openUrlInNewTab(true),
                    
                Tables\Actions\Action::make('download_direct')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function ($record) {
                        $filePath = $record->email ?? null;
                        $fileName = $record->name ?? 'file';
                        
                        if ($filePath) {
                            $fullPath = storage_path('app/public/' . $filePath);
                            if (file_exists($fullPath)) {
                                \Log::info('Download action', ['file' => $fileName]);
                                return response()->download($fullPath, $fileName);
                            }
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Error')
                            ->body('File tidak ditemukan')
                            ->danger()
                            ->send();
                    }),
                    
                Tables\Actions\Action::make('delete_direct')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->url(fn ($record) => route('file.delete', ['path' => urlencode($record->email ?? '')]))
                    ->openUrlInNewTab(false)
                    ->extraAttributes([
                        'onclick' => 'return confirm("Apakah Anda yakin ingin menghapus file ini?")'
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('delete_files')
                    ->label('Hapus Terpilih')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus File Terpilih?')
                    ->modalDescription('File yang dipilih akan dihapus permanen')
                    ->action(function ($records) {
                        \Log::info('Bulk delete started', [
                            'records_count' => count($records),
                            'records' => $records->toArray()
                        ]);
                        
                        $deleted = 0;
                        $errors = [];
                        
                        foreach ($records as $record) {
                            try {
                                $filePath = $record->email ?? null; // Use email field as path
                                $fileName = $record->name ?? 'unknown';
                                
                                \Log::info('Processing file for delete', [
                                    'file_name' => $fileName,
                                    'file_path' => $filePath,
                                    'record_email' => $record->email,
                                    'record_name' => $record->name
                                ]);
                                
                                if ($filePath && Storage::disk('public')->exists($filePath)) {
                                    $result = Storage::disk('public')->delete($filePath);
                                    if ($result) {
                                        $deleted++;
                                        \Log::info('File deleted successfully', ['file' => $fileName]);
                                    } else {
                                        $errors[] = "Gagal hapus: $fileName";
                                        \Log::warning('Delete operation failed', ['file' => $fileName]);
                                    }
                                } else {
                                    $errors[] = "File tidak ditemukan: $fileName";
                                    \Log::warning('File not found', [
                                        'file_path' => $filePath,
                                        'exists' => Storage::disk('public')->exists($filePath ?? ''),
                                        'public_path' => storage_path('app/public/' . $filePath)
                                    ]);
                                }
                            } catch (\Exception $e) {
                                $errors[] = "Error: {$e->getMessage()}";
                                \Log::error('Error deleting file', [
                                    'error' => $e->getMessage(),
                                    'file' => $record->name ?? 'unknown'
                                ]);
                            }
                        }
                        
                        // Show detailed notification
                        if ($deleted > 0) {
                            Notification::make()
                                ->title('Berhasil')
                                ->body("$deleted file berhasil dihapus" . (count($errors) > 0 ? ". " . count($errors) . " file gagal." : ""))
                                ->success()
                                ->send();
                        }
                        
                        if (count($errors) > 0) {
                            Notification::make()
                                ->title('Ada Error')
                                ->body(implode(', ', array_slice($errors, 0, 3)) . (count($errors) > 3 ? '...' : ''))
                                ->warning()
                                ->send();
                        }
                        
                        if ($deleted === 0 && count($errors) === 0) {
                            Notification::make()
                                ->title('Info')
                                ->body('Tidak ada file yang dipilih atau ditemukan')
                                ->info()
                                ->send();
                        }
                    }),
            ])
            ->defaultSort('name', 'asc')
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
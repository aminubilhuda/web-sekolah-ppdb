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
                Tables\Actions\BulkAction::make('delete_selected_files')
                    ->label('Hapus File Terpilih')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus File yang Dipilih?')
                    ->modalDescription('File yang dipilih akan dihapus permanen')
                    ->action(function ($records, $livewire) {
                        \Log::info('=== CHECKBOX BULK DELETE START ===');
                        
                        // Get selected keys from livewire component
                        $selectedKeys = $livewire->selectedTableRecords ?? [];
                        \Log::info('Selected keys from livewire', ['keys' => $selectedKeys]);
                        
                        if (empty($selectedKeys)) {
                            \Filament\Notifications\Notification::make()
                                ->title('Info')
                                ->body('Tidak ada file yang dipilih. Silakan centang checkbox file yang ingin dihapus.')
                                ->info()
                                ->send();
                            return;
                        }
                        
                        // Get all files from storage to match with selected IDs
                        $storageFiles = collect();
                        $publicPath = storage_path('app/public');
                        
                        if (\Illuminate\Support\Facades\File::exists($publicPath)) {
                            $files = \Illuminate\Support\Facades\File::allFiles($publicPath);
                            
                            foreach ($files as $file) {
                                $relativePath = str_replace($publicPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                                $relativePath = str_replace('\\', '/', $relativePath);
                                
                                if (basename($relativePath) === '.gitignore') {
                                    continue;
                                }
                                
                                $fileId = abs(crc32($relativePath));
                                $storageFiles->put($fileId, [
                                    'id' => $fileId,
                                    'name' => $file->getFilename(),
                                    'path' => $relativePath,
                                ]);
                            }
                        }
                        
                        \Log::info('Storage files loaded', ['count' => $storageFiles->count()]);
                        
                        $deleted = 0;
                        $errors = [];
                        
                        foreach ($selectedKeys as $selectedId) {
                            try {
                                $fileData = $storageFiles->get($selectedId);
                                
                                if (!$fileData) {
                                    $errors[] = "File dengan ID $selectedId tidak ditemukan";
                                    continue;
                                }
                                
                                $filePath = $fileData['path'];
                                $fileName = $fileData['name'];
                                
                                \Log::info('Processing selected file', [
                                    'id' => $selectedId,
                                    'name' => $fileName,
                                    'path' => $filePath
                                ]);
                                
                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
                                    $result = \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
                                    if ($result) {
                                        $deleted++;
                                        \Log::info('Checkbox bulk delete success', ['file' => $fileName]);
                                    } else {
                                        $errors[] = "Gagal hapus: $fileName";
                                    }
                                } else {
                                    $errors[] = "File tidak ditemukan: $fileName";
                                }
                            } catch (\Exception $e) {
                                $errors[] = "Error: {$e->getMessage()}";
                                \Log::error('Checkbox bulk delete error', [
                                    'error' => $e->getMessage(),
                                    'id' => $selectedId
                                ]);
                            }
                        }
                        
                        \Log::info('=== CHECKBOX BULK DELETE END ===', [
                            'selected_count' => count($selectedKeys),
                            'deleted' => $deleted,
                            'errors' => count($errors)
                        ]);
                        
                        // Show results
                        if ($deleted > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Berhasil')
                                ->body("$deleted file berhasil dihapus dari " . count($selectedKeys) . " file yang dipilih")
                                ->success()
                                ->send();
                        }
                        
                        if (count($errors) > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Ada Error')
                                ->body(count($errors) . " file gagal dihapus: " . implode(', ', array_slice($errors, 0, 2)))
                                ->warning()
                                ->send();
                        }
                        
                        if ($deleted === 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Info')
                                ->body('Tidak ada file yang berhasil dihapus')
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

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_file_manager');
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_file_manager');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_file_manager');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_file_manager');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('view_file_manager');
    }
} 
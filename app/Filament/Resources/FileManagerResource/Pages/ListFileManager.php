<?php

namespace App\Filament\Resources\FileManagerResource\Pages;

use App\Filament\Resources\FileManagerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ListFileManager extends ListRecords
{
    protected static string $resource = FileManagerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->action(function () {
                    return redirect()->route('filament.abdira.resources.file-managers.index');
                }),
                
            Actions\Action::make('bulk_delete')
                ->label('Hapus Multiple File')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->form([
                    \Filament\Forms\Components\Textarea::make('file_patterns')
                        ->label('Pola File untuk Dihapus')
                        ->placeholder('Contoh: *.jpg, alumni/*, berita/*.png (satu per baris)')
                        ->rows(3)
                        ->helperText('Masukkan pola file yang ingin dihapus. Gunakan * untuk wildcard.')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $patterns = explode("\n", trim($data['file_patterns']));
                    $patterns = array_map('trim', $patterns);
                    $patterns = array_filter($patterns);
                    
                    $deleted = 0;
                    $errors = [];
                    
                    foreach ($patterns as $pattern) {
                        try {
                            if (strpos($pattern, '*') !== false) {
                                // Handle wildcard patterns
                                $publicPath = storage_path('app/public');
                                $files = \Illuminate\Support\Facades\File::allFiles($publicPath);
                                
                                foreach ($files as $file) {
                                    $relativePath = str_replace($publicPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                                    $relativePath = str_replace('\\', '/', $relativePath);
                                    
                                    if ($this->matchesPattern($relativePath, $pattern)) {
                                        if (\Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath)) {
                                            $deleted++;
                                            \Log::info('Bulk pattern delete', ['file' => $relativePath, 'pattern' => $pattern]);
                                        }
                                    }
                                }
                            } else {
                                // Direct file path
                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($pattern)) {
                                    if (\Illuminate\Support\Facades\Storage::disk('public')->delete($pattern)) {
                                        $deleted++;
                                        \Log::info('Direct file delete', ['file' => $pattern]);
                                    }
                                } else {
                                    $errors[] = "File tidak ditemukan: $pattern";
                                }
                            }
                        } catch (\Exception $e) {
                            $errors[] = "Error: {$e->getMessage()}";
                            \Log::error('Bulk delete pattern error', ['pattern' => $pattern, 'error' => $e->getMessage()]);
                        }
                    }
                    
                    // Show results
                    if ($deleted > 0) {
                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil')
                            ->body("$deleted file berhasil dihapus" . (count($errors) > 0 ? ". " . count($errors) . " error." : ""))
                            ->success()
                            ->send();
                    }
                    
                    if (count($errors) > 0) {
                        \Filament\Notifications\Notification::make()
                            ->title('Ada Error')
                            ->body(implode(', ', array_slice($errors, 0, 3)))
                            ->warning()
                            ->send();
                    }
                    
                    if ($deleted === 0) {
                        \Filament\Notifications\Notification::make()
                            ->title('Info')
                            ->body('Tidak ada file yang dihapus')
                            ->info()
                            ->send();
                    }
                }),
                
            Actions\Action::make('test_download')
                ->label('Test Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // Find first file to test download
                    $publicPath = storage_path('app/public');
                    if (\Illuminate\Support\Facades\File::exists($publicPath)) {
                        $files = \Illuminate\Support\Facades\File::allFiles($publicPath);
                        if (!empty($files)) {
                            $firstFile = $files[0];
                            $fileName = $firstFile->getFilename();
                            
                            \Log::info('Test download', ['file' => $fileName]);
                            
                            return response()->download($firstFile->getPathname(), $fileName);
                        }
                    }
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Info')
                        ->body('Tidak ada file untuk di-download')
                        ->info()
                        ->send();
                }),
        ];
    }

    private function matchesPattern($filename, $pattern)
    {
        // Simple wildcard matching
        $pattern = str_replace('*', '.*', $pattern);
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/i';
        
        return preg_match($pattern, $filename);
    }

    public function mount(): void
    {
        parent::mount();
        
        // Handle test parameter
        if (request()->get('test') === '1') {
            \Filament\Notifications\Notification::make()
                ->title('Test Berhasil!')
                ->body('Action URL berhasil dipanggil! Action sistem bekerja.')
                ->success()
                ->send();
        }
        
        // Handle flash messages from redirect
        if (session()->has('success')) {
            \Filament\Notifications\Notification::make()
                ->title('Berhasil')
                ->body(session('success'))
                ->success()
                ->send();
        }
        
        if (session()->has('error')) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body(session('error'))
                ->danger()
                ->send();
        }
    }

    public function getTableRecords(): \Illuminate\Pagination\Paginator
    {
        try {
            $storageFiles = collect();
            $publicPath = storage_path('app/public');
            
            \Log::info('Starting file discovery', ['path' => $publicPath]);
            
            if (File::exists($publicPath)) {
                $files = File::allFiles($publicPath);
                
                \Log::info('Found files', ['count' => count($files)]);
                
                foreach ($files as $file) {
                    try {
                        $relativePath = str_replace($publicPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                        $relativePath = str_replace('\\', '/', $relativePath);
                        
                        if (basename($relativePath) === '.gitignore') {
                            continue;
                        }
                        
                        // Create User instance for file data (using as dummy container)
                        $userInstance = new \App\Models\User();
                        $userInstance->id = abs(crc32($relativePath));
                        $userInstance->name = $file->getFilename();
                        $userInstance->email = $relativePath; // Store path in email field
                        $userInstance->created_at = Carbon::createFromTimestamp($file->getMTime());
                        $userInstance->updated_at = Carbon::createFromTimestamp($file->getMTime());
                        
                        // Add custom attributes for file info
                        $userInstance->setAttribute('size', $file->getSize());
                        $userInstance->setAttribute('type', $file->getExtension());
                        $userInstance->setAttribute('path', $relativePath);
                        
                        // Mark as existing
                        $userInstance->exists = true;
                        $userInstance->syncOriginal();
                        
                        $storageFiles->push($userInstance);
                        
                    } catch (\Exception $e) {
                        \Log::warning('Error processing file', [
                            'file' => $file->getPathname(),
                            'error' => $e->getMessage()
                        ]);
                        continue;
                    }
                }
            }

            \Log::info('File processing complete', ['total_files' => $storageFiles->count()]);

            // Simple pagination
            $perPage = 25;
            $currentPage = max(1, (int) Paginator::resolveCurrentPage());
            $offset = ($currentPage - 1) * $perPage;
            
            $items = $storageFiles->slice($offset, $perPage)->values();
            
            \Log::info('Pagination info', [
                'current_page' => $currentPage,
                'per_page' => $perPage,
                'offset' => $offset,
                'items_count' => $items->count()
            ]);
            
            return new Paginator(
                $items,
                $perPage,
                $currentPage,
                [
                    'path' => request()->url(),
                    'pageName' => 'page',
                ]
            );
            
        } catch (\Exception $e) {
            \Log::error('Fatal error in getTableRecords', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return new Paginator(
                collect(),
                25,
                1,
                [
                    'path' => request()->url(),
                    'pageName' => 'page',
                ]
            );
        }
    }
} 
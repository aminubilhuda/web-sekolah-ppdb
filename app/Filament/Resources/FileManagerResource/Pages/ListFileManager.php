<?php

namespace App\Filament\Resources\FileManagerResource\Pages;

use App\Filament\Resources\FileManagerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

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
                
            Actions\Action::make('storage_info')
                ->label('Info Storage')
                ->icon('heroicon-o-server')
                ->color('warning')
                ->modalHeading('Informasi Storage')
                ->modalDescription($this->getStorageInfo())
                ->slideOver(),
        ];
    }

    protected function paginateTableQuery(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Pagination\Paginator
    {
        try {
            $storageFiles = collect();
            $publicPath = storage_path('app/public');
            
            if (File::exists($publicPath)) {
                $files = File::allFiles($publicPath);
                
                foreach ($files as $file) {
                    try {
                        $relativePath = str_replace($publicPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                        $relativePath = str_replace('\\', '/', $relativePath);
                        
                        // Skip .gitignore files
                        if (basename($relativePath) === '.gitignore') {
                            continue;
                        }
                        
                        // Create User instance
                        $userInstance = new User();
                        $userInstance->id = abs(crc32($relativePath));
                        $userInstance->name = $file->getFilename();
                        $userInstance->email = $relativePath; // Store path in email
                        $userInstance->created_at = Carbon::createFromTimestamp($file->getMTime());
                        $userInstance->updated_at = Carbon::createFromTimestamp($file->getMTime());
                        
                        // Add custom attributes
                        $userInstance->setAttribute('size', $file->getSize());
                        $userInstance->setAttribute('type', $file->getExtension());
                        $userInstance->setAttribute('modified', Carbon::createFromTimestamp($file->getMTime()));
                        
                        // Mark as existing
                        $userInstance->exists = true;
                        $userInstance->syncOriginal();
                        
                        $storageFiles->push($userInstance);
                        
                    } catch (\Exception $e) {
                        continue; // Skip problematic files
                    }
                }
            }

            // Apply filters
            $filteredFiles = $this->applyFilters($storageFiles);

            // Sort files
            $sortColumn = $this->getTableSortColumn() ?? 'modified';
            $sortDirection = $this->getTableSortDirection() ?? 'desc';
            
            $filteredFiles = $filteredFiles->sortBy(function ($file) use ($sortColumn) {
                switch ($sortColumn) {
                    case 'name':
                        return $file->name;
                    case 'size':
                        return $file->getAttribute('size');
                    case 'modified':
                        return $file->getAttribute('modified');
                    case 'type':
                        return $file->getAttribute('type');
                    default:
                        return $file->getAttribute($sortColumn) ?? $file->{$sortColumn};
                }
            }, SORT_REGULAR, $sortDirection === 'desc');

            // Paginate
            $perPage = max(25, (int) $this->getTableRecordsPerPage());
            $currentPage = max(1, (int) Paginator::resolveCurrentPage());
            $offset = ($currentPage - 1) * $perPage;
            
            $items = $filteredFiles->slice($offset, $perPage)->values();
            
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
            // Return empty paginator on error
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

    protected function applyFilters($collection)
    {
        $filters = $this->getTableFilters();

        // Filter by file type
        if (isset($filters['type']) && $filters['type']['value']) {
            $collection = $collection->filter(function ($file) use ($filters) {
                return $file->getAttribute('type') === $filters['type']['value'];
            });
        }

        return $collection;
    }

    protected function getStorageInfo(): string
    {
        $publicPath = storage_path('app/public');
        $totalFiles = 0;
        $totalSize = 0;

        if (File::exists($publicPath)) {
            $files = File::allFiles($publicPath);
            $totalFiles = count($files);
            
            foreach ($files as $file) {
                try {
                    $totalSize += $file->getSize();
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return "Total Files: $totalFiles | Total Size: " . $this->formatBytes($totalSize);
    }

    protected function formatBytes($bytes, $precision = 2)
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
} 
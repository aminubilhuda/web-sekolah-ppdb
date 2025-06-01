<?php

namespace App\Traits;

use Filament\Forms\Components\FileUpload;

trait HasOptimizedFileUpload
{
    protected function optimizedFileUpload(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->disk('public')
            ->directory($directory)
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth('800')
            ->imageResizeTargetHeight('800')
            ->optimize()
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->maxSize(2048);
    }

    protected function optimizedImageUpload(string $name, string $directory, int $width = 800, int $height = 800): FileUpload
    {
        return $this->optimizedFileUpload($name, $directory)
            ->imageResizeTargetWidth($width)
            ->imageResizeTargetHeight($height);
    }
} 
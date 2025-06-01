<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class FileUploadService
{
    protected string $disk = 'public';
    protected array $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
    protected int $maxFileSize = 5120; // 5MB
    protected array $imageSizes = [
        'thumb' => [150, 150],
        'medium' => [300, 300],
        'large' => [800, 800],
    ];

    public function upload(UploadedFile $file, string $path, bool $optimize = true): array
    {
        $this->validateFile($file);

        $filename = $this->generateFilename($file);
        $fullPath = "{$path}/{$filename}";

        if ($this->isImage($file) && $optimize) {
            return $this->handleImageUpload($file, $path, $filename);
        }

        Storage::disk($this->disk)->putFileAs($path, $file, $filename);

        return [
            'path' => $fullPath,
            'url' => Storage::disk($this->disk)->url($fullPath),
            'filename' => $filename,
        ];
    }

    protected function handleImageUpload(UploadedFile $file, string $path, string $filename): array
    {
        $image = Image::make($file);
        $result = [];

        // Original
        $originalPath = "{$path}/{$filename}";
        Storage::disk($this->disk)->put($originalPath, $image->encode());

        $result['original'] = [
            'path' => $originalPath,
            'url' => Storage::disk($this->disk)->url($originalPath),
        ];

        // Generate different sizes
        foreach ($this->imageSizes as $size => $dimensions) {
            $sizeFilename = "{$size}_{$filename}";
            $sizePath = "{$path}/{$sizeFilename}";

            $resized = $image->fit($dimensions[0], $dimensions[1]);
            Storage::disk($this->disk)->put($sizePath, $resized->encode());

            $result[$size] = [
                'path' => $sizePath,
                'url' => Storage::disk($this->disk)->url($sizePath),
            ];
        }

        return $result;
    }

    protected function validateFile(UploadedFile $file): void
    {
        if (!in_array($file->getMimeType(), $this->allowedMimes)) {
            throw new \InvalidArgumentException('File type not allowed');
        }

        if ($file->getSize() > $this->maxFileSize * 1024) {
            throw new \InvalidArgumentException('File size exceeds limit');
        }
    }

    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return Str::random(40) . '.' . $extension;
    }

    protected function isImage(UploadedFile $file): bool
    {
        return Str::startsWith($file->getMimeType(), 'image/');
    }

    public function delete(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }
        return false;
    }

    public function deleteWithSizes(string $path): bool
    {
        $filename = basename($path);
        $directory = dirname($path);

        // Delete original
        $this->delete($path);

        // Delete all sizes
        foreach ($this->imageSizes as $size => $dimensions) {
            $sizePath = "{$directory}/{$size}_{$filename}";
            $this->delete($sizePath);
        }

        return true;
    }
} 
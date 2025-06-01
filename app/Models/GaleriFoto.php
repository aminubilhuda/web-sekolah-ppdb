<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class GaleriFoto extends Model
{
    use HasFactory;

    protected $table = 'galeri_foto';
    public $timestamps = true;

    protected $fillable = [
        'galeri_id',
        'nama_foto',
        'file_foto',
        'deskripsi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'urutan' => 'integer',
        'is_active' => 'boolean',
    ];

    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class, 'galeri_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->file_foto ? asset('storage/' . $this->file_foto) : null;
    }

    public static function getCached()
    {
        return Cache::remember('galeri_foto_all', 3600, function () {
            return self::with(['galeri'])
                ->orderBy('urutan')
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('galeri_foto_active', 3600, function () {
            return self::where('is_active', true)
                ->with(['galeri'])
                ->orderBy('urutan')
                ->get();
        });
    }

    public static function getCachedByGaleri($galeriId)
    {
        return Cache::remember("galeri_foto_galeri_{$galeriId}", 3600, function () use ($galeriId) {
            return self::where('galeri_id', $galeriId)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($foto) {
            Cache::forget('galeri_foto_all');
            Cache::forget('galeri_foto_active');
            Cache::forget("galeri_foto_galeri_{$foto->galeri_id}");
        });

        static::deleted(function ($foto) {
            Cache::forget('galeri_foto_all');
            Cache::forget('galeri_foto_active');
            Cache::forget("galeri_foto_galeri_{$foto->galeri_id}");
        });
    }
} 
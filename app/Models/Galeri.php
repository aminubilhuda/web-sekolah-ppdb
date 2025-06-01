<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'jenis',
        'url_video',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'jenis' => 'string',
    ];

    protected $attributes = [
        'jenis' => 'foto',
        'status' => true
    ];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function getVideoUrlAttribute()
    {
        return $this->url_video;
    }

    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class);
    }

    public static function getCached()
    {
        return Cache::remember('galeri_all', 3600, function () {
            return self::get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('galeri_active', 3600, function () {
            return self::where('status', true)
                ->get();
        });
    }

    public static function getCachedByJenis($jenis)
    {
        return Cache::remember("galeri_jenis_{$jenis}", 3600, function () use ($jenis) {
            return self::where('jenis', $jenis)
                ->where('status', true)
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($galeri) {
            Cache::forget('galeri_all');
            Cache::forget('galeri_active');
            Cache::forget("galeri_jenis_{$galeri->jenis}");
        });

        static::deleted(function ($galeri) {
            Cache::forget('galeri_all');
            Cache::forget('galeri_active');
            Cache::forget("galeri_jenis_{$galeri->jenis}");
        });
    }
} 
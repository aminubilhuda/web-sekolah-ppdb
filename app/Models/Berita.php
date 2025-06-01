<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Cache;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'slug',
        'kategori_id',
        'konten',
        'image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public static function getCached()
    {
        return Cache::remember('berita_all', 3600, function () {
            return self::with(['kategori'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('berita_active', 3600, function () {
            return self::where('is_published', true)
                ->where('published_at', '<=', now())
                ->with(['kategori'])
                ->get();
        });
    }

    public static function getCachedByKategori($kategoriId)
    {
        return Cache::remember("berita_kategori_{$kategoriId}", 3600, function () use ($kategoriId) {
            return self::where('kategori_id', $kategoriId)
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->with(['kategori'])
                ->get();
        });
    }

    public static function getCachedBySlug($slug)
    {
        return Cache::remember("berita_slug_{$slug}", 3600, function () use ($slug) {
            return self::where('slug', $slug)
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->with(['kategori'])
                ->first();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($berita) {
            if (!$berita->slug) {
                $berita->slug = Str::slug($berita->judul);
            }
        });

        static::saved(function ($berita) {
            Cache::forget('berita_all');
            Cache::forget('berita_active');
            Cache::forget("berita_kategori_{$berita->kategori_id}");
            Cache::forget("berita_slug_{$berita->slug}");
        });

        static::deleted(function ($berita) {
            Cache::forget('berita_all');
            Cache::forget('berita_active');
            Cache::forget("berita_kategori_{$berita->kategori_id}");
            Cache::forget("berita_slug_{$berita->slug}");
        });
    }
} 
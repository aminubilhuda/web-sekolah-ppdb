<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategori_id');
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'kategori_id', 'id_kategori');
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'kategori_id', 'id_kategori');
    }

    public static function getCached()
    {
        return Cache::remember('kategori_all', 3600, function () {
            return self::withCount(['berita'])
                ->get();
        });
    }

    public static function getCachedBySlug($slug)
    {
        return Cache::remember("kategori_slug_{$slug}", 3600, function () use ($slug) {
            return self::where('slug', $slug)
                ->withCount(['berita'])
                ->first();
        });
    }

    public static function getCachedOptions()
    {
        return Cache::remember('kategori_options', 3600, function () {
            return self::pluck('nama', 'id')
                ->toArray();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($kategori) {
            if (!$kategori->slug) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });

        static::saved(function ($kategori) {
            Cache::forget('kategori_all');
            Cache::forget('kategori_options');
            Cache::forget("kategori_slug_{$kategori->slug}");
        });

        static::deleted(function ($kategori) {
            Cache::forget('kategori_all');
            Cache::forget('kategori_options');
            Cache::forget("kategori_slug_{$kategori->slug}");
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 
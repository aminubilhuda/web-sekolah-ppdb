<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fasilitas) {
            if (empty($fasilitas->slug)) {
                $fasilitas->slug = Str::slug($fasilitas->nama);
            }
        });

        static::updating(function ($fasilitas) {
            if ($fasilitas->isDirty('nama') && empty($fasilitas->slug)) {
                $fasilitas->slug = Str::slug($fasilitas->nama);
            }
        });

        static::saved(function ($fasilitas) {
            Cache::forget('fasilitas_all');
            Cache::forget('fasilitas_active');
        });

        static::deleted(function ($fasilitas) {
            Cache::forget('fasilitas_all');
            Cache::forget('fasilitas_active');
        });
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    // Scope untuk filtering
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Caching methods
    public static function getCached()
    {
        return Cache::remember('fasilitas_all', 3600, function () {
            return self::orderBy('nama')->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('fasilitas_active', 3600, function () {
            return self::where('status', 'active')
                ->orderBy('nama')
                ->get();
        });
    }

    public static function getStatusOptions()
    {
        return [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
        ];
    }
} 
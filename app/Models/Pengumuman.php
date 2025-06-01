<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    public $timestamps = true;

    protected $fillable = [
        'judul',
        'konten',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_publish',
        'is_published',
        'is_active',
        'user_id',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_publish' => 'datetime',
        'is_published' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getCached()
    {
        return Cache::remember('pengumuman_all', 3600, function () {
            return self::with(['user'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('pengumuman_active', 3600, function () {
            return self::where('is_active', true)
                ->where('is_published', true)
                ->where('tanggal_publish', '<=', now())
                ->with(['user'])
                ->get();
        });
    }

    public static function getCachedByUser($userId)
    {
        return Cache::remember("pengumuman_user_{$userId}", 3600, function () use ($userId) {
            return self::where('user_id', $userId)
                ->where('is_active', true)
                ->where('is_published', true)
                ->with(['user'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($pengumuman) {
            Cache::forget('pengumuman_all');
            Cache::forget('pengumuman_active');
            Cache::forget("pengumuman_user_{$pengumuman->user_id}");
        });

        static::deleted(function ($pengumuman) {
            Cache::forget('pengumuman_all');
            Cache::forget('pengumuman_active');
            Cache::forget("pengumuman_user_{$pengumuman->user_id}");
        });
    }
}

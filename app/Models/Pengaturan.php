<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'logo',
        'deskripsi',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public static function getCached()
    {
        return Cache::remember('pengaturan_all', 3600, function () {
            return self::with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    public static function getCachedByNPSN($npsn)
    {
        return Cache::remember("pengaturan_npsn_{$npsn}", 3600, function () use ($npsn) {
            return self::where('npsn', $npsn)
                ->with(['user'])
                ->withCount(['user'])
                ->first();
        });
    }

    public static function getCachedByUser($userId)
    {
        return Cache::remember("pengaturan_user_{$userId}", 3600, function () use ($userId) {
            return self::where('user_id', $userId)
                ->with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($pengaturan) {
            Cache::forget('pengaturan_all');
            Cache::forget("pengaturan_npsn_{$pengaturan->npsn}");
            Cache::forget("pengaturan_user_{$pengaturan->user_id}");
        });

        static::deleted(function ($pengaturan) {
            Cache::forget('pengaturan_all');
            Cache::forget("pengaturan_npsn_{$pengaturan->npsn}");
            Cache::forget("pengaturan_user_{$pengaturan->user_id}");
        });
    }
} 
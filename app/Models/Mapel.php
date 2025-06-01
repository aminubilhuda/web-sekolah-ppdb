<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';
    public $timestamps = true;

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kkm',
        'jumlah_jam',
        'is_active',
    ];

    protected $casts = [
        'kkm' => 'float',
        'jumlah_jam' => 'integer',
        'is_active' => 'boolean',
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }

    // Caching methods
    public static function getCached()
    {
        return Cache::remember('mapel_all', 3600, function () {
            return self::withCount('nilai')->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('mapel_active', 3600, function () {
            return self::where('is_active', true)
                ->withCount('nilai')
                ->get();
        });
    }

    public static function getCachedByGuru($guruId)
    {
        return Cache::remember("mapel_guru_{$guruId}", 3600, function () use ($guruId) {
            return self::where('guru_id', $guruId)
                ->where('is_active', true)
                ->with(['guru'])
                ->withCount('nilai')
                ->get();
        });
    }

    // Cache invalidation
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($mapel) {
            Cache::forget('mapel_all');
            Cache::forget('mapel_active');
            Cache::forget("mapel_guru_{$mapel->guru_id}");
        });

        static::deleted(function ($mapel) {
            Cache::forget('mapel_all');
            Cache::forget('mapel_active');
            Cache::forget("mapel_guru_{$mapel->guru_id}");
        });
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    public $timestamps = true;

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'nilai_angka',
        'semester',
        'tahun_ajaran',
        'kurikulum',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'nilai_angka' => 'float',
        'is_active' => 'boolean',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    // Caching methods
    public static function getCached()
    {
        return Cache::remember('nilai_all', 3600, function () {
            return self::with(['siswa', 'mapel'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('nilai_active', 3600, function () {
            return self::where('is_active', true)
                ->with(['siswa', 'mapel'])
                ->get();
        });
    }

    public static function getCachedBySiswa($siswaId)
    {
        return Cache::remember("nilai_siswa_{$siswaId}", 3600, function () use ($siswaId) {
            return self::where('siswa_id', $siswaId)
                ->where('is_active', true)
                ->with(['siswa', 'mapel'])
                ->get();
        });
    }

    public static function getCachedByMapel($mapelId)
    {
        return Cache::remember("nilai_mapel_{$mapelId}", 3600, function () use ($mapelId) {
            return self::where('mapel_id', $mapelId)
                ->where('is_active', true)
                ->with(['siswa', 'mapel'])
                ->get();
        });
    }

    public static function getCachedBySemester($semester, $tahunAjaran)
    {
        return Cache::remember("nilai_semester_{$semester}_{$tahunAjaran}", 3600, function () use ($semester, $tahunAjaran) {
            return self::where('semester', $semester)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('is_active', true)
                ->with(['siswa', 'mapel'])
                ->get();
        });
    }

    // Cache invalidation
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($nilai) {
            Cache::forget('nilai_all');
            Cache::forget('nilai_active');
            Cache::forget("nilai_siswa_{$nilai->siswa_id}");
            Cache::forget("nilai_mapel_{$nilai->mapel_id}");
            Cache::forget("nilai_semester_{$nilai->semester}_{$nilai->tahun_ajaran}");
        });

        static::deleted(function ($nilai) {
            Cache::forget('nilai_all');
            Cache::forget('nilai_active');
            Cache::forget("nilai_siswa_{$nilai->siswa_id}");
            Cache::forget("nilai_mapel_{$nilai->mapel_id}");
            Cache::forget("nilai_semester_{$nilai->semester}_{$nilai->tahun_ajaran}");
        });
    }
}
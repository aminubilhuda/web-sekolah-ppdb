<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    public $timestamps = true;

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal',
        'status',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    // Caching methods
    public static function getCached()
    {
        return Cache::remember('absensi_all', 3600, function () {
            return self::with(['siswa', 'guru'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('absensi_active', 3600, function () {
            return self::where('is_active', true)
                ->with(['siswa', 'guru'])
                ->get();
        });
    }

    public static function getCachedBySiswa($siswaId)
    {
        return Cache::remember("absensi_siswa_{$siswaId}", 3600, function () use ($siswaId) {
            return self::where('siswa_id', $siswaId)
                ->where('is_active', true)
                ->with(['siswa', 'guru'])
                ->get();
        });
    }

    public static function getCachedByGuru($guruId)
    {
        return Cache::remember("absensi_guru_{$guruId}", 3600, function () use ($guruId) {
            return self::where('guru_id', $guruId)
                ->where('is_active', true)
                ->with(['siswa', 'guru'])
                ->get();
        });
    }

    public static function getCachedByTanggal($tanggal)
    {
        return Cache::remember("absensi_tanggal_{$tanggal}", 3600, function () use ($tanggal) {
            return self::whereDate('tanggal', $tanggal)
                ->where('is_active', true)
                ->with(['siswa', 'guru'])
                ->get();
        });
    }

    public static function getCachedByStatus($status)
    {
        return Cache::remember("absensi_status_{$status}", 3600, function () use ($status) {
            return self::where('status', $status)
                ->where('is_active', true)
                ->with(['siswa', 'guru'])
                ->get();
        });
    }

    // Cache invalidation
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($absensi) {
            Cache::forget('absensi_all');
            Cache::forget('absensi_active');
            Cache::forget("absensi_siswa_{$absensi->siswa_id}");
            Cache::forget("absensi_guru_{$absensi->guru_id}");
            Cache::forget("absensi_tanggal_{$absensi->tanggal}");
            Cache::forget("absensi_status_{$absensi->status}");
        });

        static::deleted(function ($absensi) {
            Cache::forget('absensi_all');
            Cache::forget('absensi_active');
            Cache::forget("absensi_siswa_{$absensi->siswa_id}");
            Cache::forget("absensi_guru_{$absensi->guru_id}");
            Cache::forget("absensi_tanggal_{$absensi->tanggal}");
            Cache::forget("absensi_status_{$absensi->status}");
        });
    }
} 
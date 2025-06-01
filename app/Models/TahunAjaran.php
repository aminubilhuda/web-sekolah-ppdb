<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public static function getCached()
    {
        return Cache::remember('tahun_ajaran_all', 3600, function () {
            return self::with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('tahun_ajaran_active', 3600, function () {
            return self::where('is_active', true)
                ->with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->get();
        });
    }

    public static function getCachedCurrent()
    {
        return Cache::remember('tahun_ajaran_current', 3600, function () {
            return self::where('is_active', true)
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->first();
        });
    }

    public static function getCachedByDate($date)
    {
        return Cache::remember("tahun_ajaran_date_{$date}", 3600, function () use ($date) {
            return self::where('tanggal_mulai', '<=', $date)
                ->where('tanggal_selesai', '>=', $date)
                ->with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->first();
        });
    }

    public static function getCachedBySingkatan($singkatan)
    {
        return Cache::remember("tahun_ajaran_singkatan_{$singkatan}", 3600, function () use ($singkatan) {
            return self::where('singkatan', $singkatan)
                ->with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->first();
        });
    }

    public static function getCachedWithAvailableQuota()
    {
        return Cache::remember('tahun_ajaran_available_quota', 3600, function () {
            return self::where('is_active', true)
                ->with(['siswa', 'kelas'])
                ->withCount(['siswa', 'kelas'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($tahunAjaran) {
            Cache::forget('tahun_ajaran_all');
            Cache::forget('tahun_ajaran_active');
            Cache::forget('tahun_ajaran_current');
            Cache::forget("tahun_ajaran_date_{$tahunAjaran->tanggal_mulai}");
            Cache::forget("tahun_ajaran_date_{$tahunAjaran->tanggal_selesai}");
        });

        static::deleted(function ($tahunAjaran) {
            Cache::forget('tahun_ajaran_all');
            Cache::forget('tahun_ajaran_active');
            Cache::forget('tahun_ajaran_current');
            Cache::forget("tahun_ajaran_date_{$tahunAjaran->tanggal_mulai}");
            Cache::forget("tahun_ajaran_date_{$tahunAjaran->tanggal_selesai}");
        });
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    
    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'deskripsi',
        'gambar',
        'kuota',
        'kepala_jurusan_id',
        'is_active',
    ];

    protected $casts = [
        'kuota' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the kepala jurusan that owns the jurusan.
     */
    public function kepalaJurusan(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'kepala_jurusan_id');
    }

    /**
     * Get the siswa for the jurusan.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Get the alumni for the jurusan.
     */
    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    public function ppdb()
    {
        return $this->hasMany(Ppdb::class, 'jurusan_pilihan');
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public static function getCached()
    {
        return Cache::remember('jurusan_all', 3600, function () {
            return self::with(['siswa'])
                ->withCount(['siswa'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('jurusan_active', 3600, function () {
            return self::where('is_active', true)
                ->with(['siswa'])
                ->withCount(['siswa'])
                ->get();
        });
    }

    public static function getCachedBySingkatan($singkatan)
    {
        return Cache::remember("jurusan_singkatan_{$singkatan}", 3600, function () use ($singkatan) {
            return self::where('singkatan', $singkatan)
                ->with(['siswa'])
                ->withCount(['siswa'])
                ->first();
        });
    }

    public static function getCachedWithAvailableQuota()
    {
        return Cache::remember('jurusan_available_quota', 3600, function () {
            return self::where('is_active', true)
                ->whereRaw('kuota > (SELECT COUNT(*) FROM siswa WHERE siswa.jurusan_id = jurusan.id)')
                ->with(['siswa'])
                ->withCount(['siswa'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($jurusan) {
            Cache::forget('jurusan_all');
            Cache::forget('jurusan_active');
            Cache::forget("jurusan_singkatan_{$jurusan->singkatan}");
            Cache::forget('jurusan_available_quota');
        });

        static::deleted(function ($jurusan) {
            Cache::forget('jurusan_all');
            Cache::forget('jurusan_active');
            Cache::forget("jurusan_singkatan_{$jurusan->singkatan}");
            Cache::forget('jurusan_available_quota');
        });
    }
} 
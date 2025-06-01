<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'is_active',
        'jabatan',
        'bidang_studi',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean'
    ];

    public function jurusanKepala(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'kepala_jurusan_id');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'kepala_jurusan_id');
    }

    public function kelasWali(): HasMany
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function mapel(): HasMany
    {
        return $this->hasMany(Mapel::class, 'guru_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public static function getCached()
    {
        return Cache::remember('guru.all', 3600, function () {
            return static::all();
        });
    }

    public static function getCachedByBidangStudi($bidangStudi)
    {
        return Cache::remember("guru.bidang.{$bidangStudi}", 3600, function () use ($bidangStudi) {
            return static::where('bidang_studi', $bidangStudi)->get();
        });
    }

    public static function getCachedByJabatan($jabatan)
    {
        return Cache::remember("guru.jabatan.{$jabatan}", 3600, function () use ($jabatan) {
            return static::where('jabatan', $jabatan)->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($guru) {
            Cache::forget('guru.all');
            Cache::forget("guru.bidang.{$guru->bidang_studi}");
            Cache::forget("guru.jabatan.{$guru->jabatan}");
        });

        static::deleted(function ($guru) {
            Cache::forget('guru.all');
            Cache::forget("guru.bidang.{$guru->bidang_studi}");
            Cache::forget("guru.jabatan.{$guru->jabatan}");
        });
    }
} 
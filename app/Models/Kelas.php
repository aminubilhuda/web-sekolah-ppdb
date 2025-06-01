<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan_id',
        'guru_id',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public static function getCached()
    {
        return Cache::remember('kelas.all', 3600, function () {
            return static::with(['waliKelas', 'jurusan'])
                ->withCount('siswa')
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('kelas.active', 3600, function () {
            return static::with(['waliKelas', 'jurusan'])
                ->withCount('siswa')
                ->where('is_active', true)
                ->get();
        });
    }

    public static function getCachedByJurusan($jurusanId)
    {
        return Cache::remember("kelas.jurusan.{$jurusanId}", 3600, function () use ($jurusanId) {
            return static::with(['waliKelas', 'jurusan'])
                ->withCount('siswa')
                ->where('jurusan_id', $jurusanId)
                ->where('is_active', true)
                ->get();
        });
    }

    public static function getCachedByWaliKelas($guruId)
    {
        return Cache::remember("kelas.wali.{$guruId}", 3600, function () use ($guruId) {
            return static::with(['waliKelas', 'jurusan'])
                ->withCount('siswa')
                ->where('wali_kelas_id', $guruId)
                ->where('is_active', true)
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($kelas) {
            Cache::forget('kelas.all');
            Cache::forget('kelas.active');
            Cache::forget("kelas.jurusan.{$kelas->jurusan_id}");
            Cache::forget("kelas.wali.{$kelas->wali_kelas_id}");
        });

        static::deleted(function ($kelas) {
            Cache::forget('kelas.all');
            Cache::forget('kelas.active');
            Cache::forget("kelas.jurusan.{$kelas->jurusan_id}");
            Cache::forget("kelas.wali.{$kelas->wali_kelas_id}");
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Ppdb extends Model
{
    use HasFactory;

    protected $table = 'ppdb';
    protected $fillable = [
        'nomor_pendaftaran',
        'nama_lengkap',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'asal_sekolah',
        'tahun_lulus',
        'nama_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        'alamat_ortu',
        'jurusan_pilihan',
        'foto',
        'ijazah',
        'kk',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan', 'id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public function getIjazahUrlAttribute()
    {
        return $this->ijazah ? asset('storage/' . $this->ijazah) : null;
    }

    public function getKkUrlAttribute()
    {
        return $this->kk ? asset('storage/' . $this->kk) : null;
    }

    public static function getCached()
    {
        return Cache::remember('ppdb.all', 3600, function () {
            return static::with('jurusan')->get();
        });
    }

    public static function getCachedByStatus($status)
    {
        return Cache::remember("ppdb.status.{$status}", 3600, function () use ($status) {
            return static::with('jurusan')
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

    public static function getCachedByJurusan($jurusanId)
    {
        return Cache::remember("ppdb.jurusan.{$jurusanId}", 3600, function () use ($jurusanId) {
            return static::with('jurusan')
                ->where('jurusan_pilihan', $jurusanId)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

    public static function getCachedPendingCount()
    {
        return Cache::remember('ppdb.pending.count', 3600, function () {
            return static::where('status', 'pending')->count();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($ppdb) {
            Cache::forget('ppdb.all');
            Cache::forget("ppdb.status.{$ppdb->status}");
            Cache::forget("ppdb.jurusan.{$ppdb->jurusan_pilihan}");
            Cache::forget('ppdb.pending.count');
        });

        static::deleted(function ($ppdb) {
            Cache::forget('ppdb.all');
            Cache::forget("ppdb.status.{$ppdb->status}");
            Cache::forget("ppdb.jurusan.{$ppdb->jurusan_pilihan}");
            Cache::forget('ppdb.pending.count');
        });
    }
} 
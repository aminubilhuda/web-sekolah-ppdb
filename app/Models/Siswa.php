<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';
    
    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kelas',
        'jurusan_id',
        'kelas_id',
        'tahun_masuk',
        // Data Orang Tua
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        // Data Wali
        'nama_wali',
        'nik_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'hubungan_wali',
        'foto',
        'status',
        'is_active',
        'deskripsi',
        'no_hp',
        'email'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected $with = ['jurusan', 'kelas'];

    /**
     * Get the jurusan that owns the siswa.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public static function getCached()
    {
        return Cache::remember('siswa.all', 3600, function () {
            return static::with(['jurusan', 'kelas'])->get();
        });
    }

    public static function getCachedByJurusan($jurusanId)
    {
        return Cache::remember("siswa.jurusan.{$jurusanId}", 3600, function () use ($jurusanId) {
            return static::with(['jurusan', 'kelas'])
                ->where('jurusan_id', $jurusanId)
                ->get();
        });
    }

    public static function getCachedByKelas($kelasId)
    {
        return Cache::remember("siswa.kelas.{$kelasId}", 3600, function () use ($kelasId) {
            return static::with(['jurusan', 'kelas'])
                ->where('kelas_id', $kelasId)
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($siswa) {
            Cache::forget('siswa.all');
            Cache::forget("siswa.jurusan.{$siswa->jurusan_id}");
            Cache::forget("siswa.kelas.{$siswa->kelas_id}");
        });

        static::deleted(function ($siswa) {
            Cache::forget('siswa.all');
            Cache::forget("siswa.jurusan.{$siswa->jurusan_id}");
            Cache::forget("siswa.kelas.{$siswa->kelas_id}");
        });
    }
} 
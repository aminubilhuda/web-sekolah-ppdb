<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Profil extends Model
{
    use HasFactory;

    protected $table = 'profil';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'foto',
        'user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }

    public static function getCached()
    {
        return Cache::remember('profil_all', 3600, function () {
            return self::with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    public static function getCachedByNIK($nik)
    {
        return Cache::remember("profil_nik_{$nik}", 3600, function () use ($nik) {
            return self::where('nik', $nik)
                ->with(['user'])
                ->withCount(['user'])
                ->first();
        });
    }

    public static function getCachedByUser($userId)
    {
        return Cache::remember("profil_user_{$userId}", 3600, function () use ($userId) {
            return self::where('user_id', $userId)
                ->with(['user'])
                ->withCount(['user'])
                ->first();
        });
    }

    public static function getCachedByJenisKelamin($jenisKelamin)
    {
        return Cache::remember("profil_jenis_kelamin_{$jenisKelamin}", 3600, function () use ($jenisKelamin) {
            return self::where('jenis_kelamin', $jenisKelamin)
                ->with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($profil) {
            Cache::forget('profil_all');
            Cache::forget("profil_nik_{$profil->nik}");
            Cache::forget("profil_user_{$profil->user_id}");
            Cache::forget("profil_jenis_kelamin_{$profil->jenis_kelamin}");
        });

        static::deleted(function ($profil) {
            Cache::forget('profil_all');
            Cache::forget("profil_nik_{$profil->nik}");
            Cache::forget("profil_user_{$profil->user_id}");
            Cache::forget("profil_jenis_kelamin_{$profil->jenis_kelamin}");
        });
    }
} 
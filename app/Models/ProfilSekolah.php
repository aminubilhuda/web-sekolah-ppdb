<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProfilSekolah extends Model
{
    use HasFactory;

    protected $table = 'profil_sekolah';
    
    protected $fillable = [
        'nama_sekolah',
        'slug',
        'npsn',
        'status',
        'jenis',
        'status_akreditasi',
        'email',
        'no_hp',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kode_pos',
        'lokasi_maps',
        'sk_pendirian',
        'sk_izin_operasional',
        'kepala_sekolah',
        'sambutan_kepala',
        'sejarah',
        'video_profile',
        'visi',
        'misi',
        'logo',
        'favicon',
        'banner_highlight',
        'gedung_image',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'whatsapp',
        'telegram',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profil) {
            if (empty($profil->slug)) {
                $profil->slug = Str::slug($profil->nama_sekolah);
            }
        });

        static::saved(function ($profil) {
            Cache::forget('profil_sekolah');
        });

        static::deleted(function ($profil) {
            Cache::forget('profil_sekolah');
        });
    }

    public static function getCached()
    {
        return Cache::remember('profil_sekolah', 3600, function () {
            return static::first();
        });
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getFaviconUrlAttribute()
    {
        return $this->favicon ? asset('storage/' . $this->favicon) : null;
    }

    public function getBannerHighlightUrlAttribute()
    {
        return $this->banner_highlight ? asset('storage/' . $this->banner_highlight) : null;
    }

    public function getGedungImageUrlAttribute()
    {
        return $this->gedung_image ? asset('storage/' . $this->gedung_image) : null;
    }
} 
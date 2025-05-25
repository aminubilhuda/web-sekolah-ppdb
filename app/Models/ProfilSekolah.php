<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';
    
    protected $fillable = [
        'nama_sekolah',
        'slug',
        'npsn',
        'status',
        'jenis',
        'status_akreditasi',
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
        'email',
        'no_hp',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kode_pos',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'whatsapp',
        'telegram',
        'banner_highlight'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profil) {
            if (empty($profil->slug)) {
                $profil->slug = Str::slug($profil->nama_sekolah);
            }
        });
    }
} 
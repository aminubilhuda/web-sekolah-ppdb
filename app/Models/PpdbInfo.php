<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PpdbInfo extends Model
{
    protected $table = 'ppdb_info';
    
    protected $fillable = [
        'judul',
        'subtitle',
        'gambar_background',
        'persyaratan',
        'jadwal',
        'panduan_pendaftaran',
        'langkah_pendaftaran',
        'telepon',
        'whatsapp',
        'email'
    ];

    protected $appends = ['gambar_background_url'];

    protected $casts = [
        'persyaratan' => 'array',
        'jadwal' => 'array',
        'langkah_pendaftaran' => 'array'
    ];

    protected $attributes = [
        'persyaratan' => '[]',
        'jadwal' => '[]',
        'langkah_pendaftaran' => '[]'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if ($model->gambar_background) {
                Storage::disk('public')->delete($model->gambar_background);
            }
        });

        static::retrieved(function ($model) {
            if (is_string($model->persyaratan)) {
                $model->persyaratan = json_decode($model->persyaratan, true) ?? [];
            }
            if (is_string($model->jadwal)) {
                $model->jadwal = json_decode($model->jadwal, true) ?? [];
            }
            if (is_string($model->langkah_pendaftaran)) {
                $model->langkah_pendaftaran = json_decode($model->langkah_pendaftaran, true) ?? [];
            }
        });

        static::saving(function ($model) {
            if (is_array($model->persyaratan)) {
                $model->persyaratan = json_encode($model->persyaratan);
            }
            if (is_array($model->jadwal)) {
                $model->jadwal = json_encode($model->jadwal);
            }
            if (is_array($model->langkah_pendaftaran)) {
                $model->langkah_pendaftaran = json_encode($model->langkah_pendaftaran);
            }
        });
    }

    public function getPersyaratanAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function getJadwalAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function getLangkahPendaftaranAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($value) ? $value : [];
    }

    public function setPersyaratanAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['persyaratan'] = '[]';
            return;
        }
        $this->attributes['persyaratan'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setJadwalAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['jadwal'] = '[]';
            return;
        }
        $this->attributes['jadwal'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setLangkahPendaftaranAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['langkah_pendaftaran'] = '[]';
            return;
        }
        $this->attributes['langkah_pendaftaran'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getGambarBackgroundUrlAttribute()
    {
        if (!$this->gambar_background) {
            return null;
        }
        
        return Storage::disk('public')->url($this->gambar_background);
    }
} 
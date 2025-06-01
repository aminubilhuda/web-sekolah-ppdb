<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'tanggal',
        'kategori_id',
        'is_published'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_published' => 'boolean'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($prestasi) {
            if (!$prestasi->slug) {
                $prestasi->slug = Str::slug($prestasi->judul);
            }
        });
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal',
        'kategori_id',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status' => 'boolean'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_id');
    }
} 
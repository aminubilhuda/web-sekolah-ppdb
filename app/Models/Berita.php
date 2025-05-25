<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'image',
        'kategori_id',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }
} 
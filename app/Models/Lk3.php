<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lk3 extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'file_path',
        'tahun',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lk3) {
            if (empty($lk3->slug)) {
                $lk3->slug = Str::slug($lk3->judul);
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agenda extends Model
{
    protected $table = 'agenda';
    
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penanggung_jawab',
        'is_published',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'status' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($agenda) {
            $agenda->slug = Str::slug($agenda->judul);
        });
        
        static::updating(function ($agenda) {
            if ($agenda->isDirty('judul')) {
                $agenda->slug = Str::slug($agenda->judul);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 
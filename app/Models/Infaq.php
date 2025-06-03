<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Infaq extends Model
{
    protected $fillable = [
        'kelas_id',
        'tanggal',
        'jumlah_infaq',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah_infaq' => 'decimal:2',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    // Scope untuk filter berdasarkan bulan
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeTahunIni($query)
    {
        return $query->whereYear('tanggal', now()->year);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', now());
    }

    // Method untuk mendapatkan total infaq
    public static function getTotalInfaq($query)
    {
        return $query->sum('jumlah_infaq');
    }
}

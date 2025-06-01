<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Kontak extends Model
{
    use HasFactory;

    protected $table = 'kontak';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'status',
        'catatan_admin',
        'tanggal_dibaca',
        'tanggal_diproses',
        'admin_id',
        'is_active',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_active' => 'boolean',
        'tanggal_dibaca' => 'timestamp',
        'tanggal_diproses' => 'timestamp',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public static function getCached()
    {
        return Cache::remember('kontak_all', 3600, function () {
            return self::with(['admin'])
                ->get();
        });
    }

    public static function getCachedByEmail($email)
    {
        return Cache::remember("kontak_email_{$email}", 3600, function () use ($email) {
            return self::where('email', $email)
                ->with(['admin'])
                ->get();
        });
    }

    public static function getCachedByAdmin($adminId)
    {
        return Cache::remember("kontak_admin_{$adminId}", 3600, function () use ($adminId) {
            return self::where('admin_id', $adminId)
                ->with(['admin'])
                ->get();
        });
    }

    public static function getCachedUnread()
    {
        return Cache::remember('kontak_unread', 3600, function () {
            return self::where('is_read', false)
                ->with(['admin'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($kontak) {
            Cache::forget('kontak_all');
            Cache::forget("kontak_email_{$kontak->email}");
            Cache::forget("kontak_admin_{$kontak->admin_id}");
            Cache::forget('kontak_unread');
        });

        static::deleted(function ($kontak) {
            Cache::forget('kontak_all');
            Cache::forget("kontak_email_{$kontak->email}");
            Cache::forget("kontak_admin_{$kontak->admin_id}");
            Cache::forget('kontak_unread');
        });
    }
} 
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
        'user_id',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCached()
    {
        return Cache::remember('kontak_all', 3600, function () {
            return self::with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    public static function getCachedByEmail($email)
    {
        return Cache::remember("kontak_email_{$email}", 3600, function () use ($email) {
            return self::where('email', $email)
                ->with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    public static function getCachedByUser($userId)
    {
        return Cache::remember("kontak_user_{$userId}", 3600, function () use ($userId) {
            return self::where('user_id', $userId)
                ->with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    public static function getCachedUnread()
    {
        return Cache::remember('kontak_unread', 3600, function () {
            return self::where('is_read', false)
                ->with(['user'])
                ->withCount(['user'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($kontak) {
            Cache::forget('kontak_all');
            Cache::forget("kontak_email_{$kontak->email}");
            Cache::forget("kontak_user_{$kontak->user_id}");
            Cache::forget('kontak_unread');
        });

        static::deleted(function ($kontak) {
            Cache::forget('kontak_all');
            Cache::forget("kontak_email_{$kontak->email}");
            Cache::forget("kontak_user_{$kontak->user_id}");
            Cache::forget('kontak_unread');
        });
    }
} 
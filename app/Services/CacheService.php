<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\ProfilSekolah;
use App\Models\Ppdb;
use App\Models\Slider;

class CacheService
{
    const CACHE_TTL = 60 * 60 * 24; // 24 hours
    const ADMIN_CACHE_TTL = 60 * 5; // 5 minutes

    public static function getProfilSekolah()
    {
        return Cache::remember('profil_sekolah', self::CACHE_TTL, function () {
            return ProfilSekolah::first();
        });
    }

    public static function getPpdbPendingCount()
    {
        return Cache::remember('ppdb_pending_count', self::ADMIN_CACHE_TTL, function () {
            return Ppdb::where('status', 'pending')->count();
        });
    }

    public static function getSliderInactiveCount()
    {
        return Cache::remember('slider_inactive_count', self::ADMIN_CACHE_TTL, function () {
            return Slider::where('is_active', false)->count();
        });
    }

    public static function clearProfilCache()
    {
        Cache::forget('profil_sekolah');
    }

    public static function clearAdminCaches()
    {
        Cache::forget('ppdb_pending_count');
        Cache::forget('slider_inactive_count');
    }

    public static function clearAllCaches()
    {
        self::clearProfilCache();
        self::clearAdminCaches();
    }
} 
<?php

namespace App\Observers;

use App\Models\Ppdb;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;

class PpdbObserver
{
    public function saved(Ppdb $ppdb)
    {
        Cache::forget('ppdb_pending_count');
        CacheService::clearAdminCaches();
    }

    public function deleted(Ppdb $ppdb)
    {
        Cache::forget('ppdb_pending_count');
        CacheService::clearAdminCaches();
    }
} 
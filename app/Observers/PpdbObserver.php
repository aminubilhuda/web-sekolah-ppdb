<?php

namespace App\Observers;

use App\Models\Ppdb;
use Illuminate\Support\Facades\Cache;
use App\Providers\AppServiceProvider;

class PpdbObserver
{
    public function saved(Ppdb $ppdb)
    {
        Cache::forget('ppdb_pending_count');
        AppServiceProvider::clearCounts();
    }

    public function deleted(Ppdb $ppdb)
    {
        Cache::forget('ppdb_pending_count');
        AppServiceProvider::clearCounts();
    }
} 
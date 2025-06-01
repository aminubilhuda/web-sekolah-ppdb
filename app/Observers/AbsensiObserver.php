<?php

namespace App\Observers;

use App\Models\Absensi;
use Illuminate\Support\Facades\Cache;

class AbsensiObserver
{
    public function saved(Absensi $absensi)
    {
        $this->clearCache($absensi);
    }

    public function deleted(Absensi $absensi)
    {
        $this->clearCache($absensi);
    }

    protected function clearCache(Absensi $absensi)
    {
        Cache::flush();
    }
} 
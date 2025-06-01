<?php

namespace App\Observers;

use App\Models\Kelas;
use Illuminate\Support\Facades\Cache;

class KelasObserver
{
    public function saved(Kelas $kelas)
    {
        $this->clearCache($kelas);
    }

    public function deleted(Kelas $kelas)
    {
        $this->clearCache($kelas);
    }

    protected function clearCache(Kelas $kelas)
    {
        Cache::flush();
    }
} 
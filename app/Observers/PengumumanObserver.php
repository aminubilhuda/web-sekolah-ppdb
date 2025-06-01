<?php

namespace App\Observers;

use App\Models\Pengumuman;
use Illuminate\Support\Facades\Cache;

class PengumumanObserver
{
    public function saved(Pengumuman $pengumuman)
    {
        $this->clearCache($pengumuman);
    }

    public function deleted(Pengumuman $pengumuman)
    {
        $this->clearCache($pengumuman);
    }

    protected function clearCache(Pengumuman $pengumuman)
    {
        Cache::flush();
    }
} 
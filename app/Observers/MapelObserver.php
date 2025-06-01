<?php

namespace App\Observers;

use App\Models\Mapel;
use Illuminate\Support\Facades\Cache;

class MapelObserver
{
    public function saved(Mapel $mapel)
    {
        $this->clearCache($mapel);
    }

    public function deleted(Mapel $mapel)
    {
        $this->clearCache($mapel);
    }

    protected function clearCache(Mapel $mapel)
    {
        Cache::flush();
    }
} 
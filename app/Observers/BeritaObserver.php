<?php

namespace App\Observers;

use App\Models\Berita;
use Illuminate\Support\Facades\Cache;

class BeritaObserver
{
    public function saved(Berita $berita)
    {
        $this->clearCache($berita);
    }

    public function deleted(Berita $berita)
    {
        $this->clearCache($berita);
    }

    protected function clearCache(Berita $berita)
    {
        Cache::flush();
    }
} 
<?php

namespace App\Observers;

use App\Models\Siswa;
use Illuminate\Support\Facades\Cache;

class SiswaObserver
{
    public function saved(Siswa $siswa)
    {
        $this->clearCache($siswa);
    }

    public function deleted(Siswa $siswa)
    {
        $this->clearCache($siswa);
    }

    protected function clearCache(Siswa $siswa)
    {
        Cache::flush();
    }
} 
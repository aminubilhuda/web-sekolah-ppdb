<?php

namespace App\Observers;

use App\Models\Guru;
use Illuminate\Support\Facades\Cache;

class GuruObserver
{
    public function saved(Guru $guru)
    {
        $this->clearCache($guru);
    }

    public function deleted(Guru $guru)
    {
        $this->clearCache($guru);
    }

    protected function clearCache(Guru $guru)
    {
        Cache::flush();
    }
} 
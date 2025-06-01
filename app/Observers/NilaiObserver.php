<?php

namespace App\Observers;

use App\Models\Nilai;
use Illuminate\Support\Facades\Cache;

class NilaiObserver
{
    public function saved(Nilai $nilai)
    {
        $this->clearCache($nilai);
    }

    public function deleted(Nilai $nilai)
    {
        $this->clearCache($nilai);
    }

    protected function clearCache(Nilai $nilai)
    {
        Cache::flush();
    }
} 
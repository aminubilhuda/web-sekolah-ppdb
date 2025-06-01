<?php

namespace App\Observers;

use App\Models\Jurusan;
use Illuminate\Support\Facades\Cache;

class JurusanObserver
{
    public function saved(Jurusan $jurusan)
    {
        $this->clearCache($jurusan);
    }

    public function deleted(Jurusan $jurusan)
    {
        $this->clearCache($jurusan);
    }

    protected function clearCache(Jurusan $jurusan)
    {
        Cache::flush();
    }
} 
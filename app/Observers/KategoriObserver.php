<?php

namespace App\Observers;

use App\Models\Kategori;
use Illuminate\Support\Facades\Cache;

class KategoriObserver
{
    public function saved(Kategori $kategori)
    {
        Cache::forget('kategori_options');
    }

    public function deleted(Kategori $kategori)
    {
        Cache::forget('kategori_options');
    }
} 
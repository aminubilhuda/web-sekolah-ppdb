<?php

namespace App\Observers;

use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use App\Services\CacheService;

class SliderObserver
{
    public function saved(Slider $slider)
    {
        CacheService::clearAdminCaches();
    }

    public function deleted(Slider $slider)
    {
        CacheService::clearAdminCaches();
    }
} 
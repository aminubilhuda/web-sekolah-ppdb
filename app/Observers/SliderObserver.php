<?php

namespace App\Observers;

use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use App\Providers\AppServiceProvider;

class SliderObserver
{
    public function saved(Slider $slider)
    {
        Cache::forget('slider_inactive_count');
        AppServiceProvider::clearCounts();
    }

    public function deleted(Slider $slider)
    {
        Cache::forget('slider_inactive_count');
        AppServiceProvider::clearCounts();
    }
} 
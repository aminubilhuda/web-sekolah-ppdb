<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Services\FileUploadService;
use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\View;
use App\Models\Ppdb;
use App\Models\Slider;

class AppServiceProvider extends ServiceProvider
{
    private static $profil = null;
    private static $ppdbPendingCount = null;
    private static $sliderInactiveCount = null;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileUploadService::class, function ($app) {
            return new FileUploadService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Model observers for cache clearing
        \App\Models\Ppdb::observe(\App\Observers\PpdbObserver::class);
        \App\Models\Jurusan::observe(\App\Observers\JurusanObserver::class);
        \App\Models\Guru::observe(\App\Observers\GuruObserver::class);
        \App\Models\Siswa::observe(\App\Observers\SiswaObserver::class);
        \App\Models\Berita::observe(\App\Observers\BeritaObserver::class);
        \App\Models\Slider::observe(\App\Observers\SliderObserver::class);

        // Share data ke semua view dalam satu composer
        View::composer('*', function ($view) {
            // Cache profil sekolah
            if (self::$profil === null) {
                self::$profil = Cache::remember('profil_sekolah', 60 * 60, function () {
                    return ProfilSekolah::first();
                });
            }

            // Cache PPDB pending count
            if (self::$ppdbPendingCount === null) {
                self::$ppdbPendingCount = Cache::remember('ppdb_pending_count', 60, function () {
                    return Ppdb::where('status', 'pending')->count();
                });
            }

            // Cache slider inactive count
            if (self::$sliderInactiveCount === null) {
                self::$sliderInactiveCount = Cache::remember('slider_inactive_count', 60, function () {
                    return Slider::where('is_active', false)->count();
                });
            }

            // Share semua data ke view
            $view->with([
                'profil' => self::$profil,
                'nama_sekolah' => self::$profil ? self::$profil->nama_sekolah : config('app.name'),
                'ppdbPendingCount' => self::$ppdbPendingCount,
                'sliderInactiveCount' => self::$sliderInactiveCount
            ]);
        });
    }

    public static function clearCounts()
    {
        self::$profil = null;
        self::$ppdbPendingCount = null;
        self::$sliderInactiveCount = null;
    }
}
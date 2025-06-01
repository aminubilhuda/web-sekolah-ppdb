<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\FileUploadService;
use App\Services\CacheService;
use Illuminate\Support\Facades\View;
use App\Models\ProfilSekolah;
use App\Models\Ppdb;
use App\Models\Slider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FileUploadService::class, function ($app) {
            return new FileUploadService();
        });

        // Singleton untuk ProfilSekolah
        $this->app->singleton('profil_sekolah', function ($app) {
            return CacheService::getProfilSekolah();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Model observers for cache clearing
        \App\Models\ProfilSekolah::observe(\App\Observers\ProfilSekolahObserver::class);
        \App\Models\Ppdb::observe(\App\Observers\PpdbObserver::class);
        \App\Models\Jurusan::observe(\App\Observers\JurusanObserver::class);
        \App\Models\Guru::observe(\App\Observers\GuruObserver::class);
        \App\Models\Siswa::observe(\App\Observers\SiswaObserver::class);
        \App\Models\Berita::observe(\App\Observers\BeritaObserver::class);
        \App\Models\Slider::observe(\App\Observers\SliderObserver::class);

        // Hanya share ke view web, bukan admin
        View::composer(['web.*', 'layouts.app'], function ($view) {
            $profil = app('profil_sekolah');
            
            $view->with([
                'profil' => $profil,
                'profilSekolah' => $profil, // Alias untuk konsistensi
                'nama_sekolah' => $profil ? $profil->nama_sekolah : config('app.name'),
            ]);
        });

        // Share data admin hanya ke view admin dengan caching yang efisien
        View::composer(['filament.*', 'admin.*'], function ($view) {
            $view->with([
                'ppdbPendingCount' => CacheService::getPpdbPendingCount(),
                'sliderInactiveCount' => CacheService::getSliderInactiveCount()
            ]);
        });
    }

    public static function clearProfilCache()
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }
}
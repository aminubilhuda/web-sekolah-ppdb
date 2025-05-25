<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $profil = ProfilSekolah::first();
            $view->with([
                'nama_sekolah' => $profil ? $profil->nama_sekolah : 'Nama Sekolah',
                'profil' => $profil
            ]);
        });
    }
}
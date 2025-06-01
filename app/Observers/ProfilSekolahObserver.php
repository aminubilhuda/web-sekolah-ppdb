<?php

namespace App\Observers;

use App\Models\ProfilSekolah;
use App\Services\CacheService;

class ProfilSekolahObserver
{
    /**
     * Handle the ProfilSekolah "created" event.
     */
    public function created(ProfilSekolah $profilSekolah): void
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }

    /**
     * Handle the ProfilSekolah "updated" event.
     */
    public function updated(ProfilSekolah $profilSekolah): void
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }

    /**
     * Handle the ProfilSekolah "deleted" event.
     */
    public function deleted(ProfilSekolah $profilSekolah): void
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }

    /**
     * Handle the ProfilSekolah "restored" event.
     */
    public function restored(ProfilSekolah $profilSekolah): void
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }

    /**
     * Handle the ProfilSekolah "force deleted" event.
     */
    public function forceDeleted(ProfilSekolah $profilSekolah): void
    {
        CacheService::clearProfilCache();
        app()->forgetInstance('profil_sekolah');
    }
} 
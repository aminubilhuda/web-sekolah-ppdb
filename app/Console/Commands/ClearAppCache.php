<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class ClearAppCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-cache {--type=all : Type of cache to clear (all, profil, admin)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear application specific caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');

        switch ($type) {
            case 'profil':
                CacheService::clearProfilCache();
                app()->forgetInstance('profil_sekolah');
                $this->info('Profil sekolah cache cleared successfully.');
                break;
                
            case 'admin':
                CacheService::clearAdminCaches();
                $this->info('Admin caches cleared successfully.');
                break;
                
            case 'all':
            default:
                CacheService::clearAllCaches();
                app()->forgetInstance('profil_sekolah');
                $this->info('All application caches cleared successfully.');
                break;
        }

        return 0;
    }
} 
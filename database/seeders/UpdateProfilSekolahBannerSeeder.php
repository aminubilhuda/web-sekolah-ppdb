<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilSekolah;

class UpdateProfilSekolahBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update profil sekolah dengan banner highlight
        ProfilSekolah::first()->update([
            'banner_highlight' => 'profil/banner/banner-highlight.jpg'
        ]);
    }
} 
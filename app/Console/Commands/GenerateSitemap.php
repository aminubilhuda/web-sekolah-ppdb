<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\Fasilitas;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml file untuk SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap.xml...');

        // Static pages dengan prioritas tinggi
        $staticPages = [
            [
                'url' => url('/'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'url' => url('/profil'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'url' => url('/profil/visi-misi'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => url('/profil/akreditasi'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => url('/profil/hubungan-industri'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'url' => url('/profil/fasilitas'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => url('/berita'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => url('/jurusan'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'url' => url('/guru'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => url('/prestasi'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'url' => url('/ppdb'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => url('/kontak'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
        ];

        $this->info('Adding static pages...');

        // Dynamic pages - Berita
        $beritaPages = collect();
        try {
            $this->info('Checking berita...');
            $totalBerita = Berita::count();
            $publishedBerita = Berita::where('is_published', true)->count();
            $publishedAndDateBerita = Berita::where('is_published', true)
                ->where('published_at', '<=', now())
                ->count();
            
            $this->info("Total berita: {$totalBerita}");
            $this->info("Published berita: {$publishedBerita}");
            $this->info("Published & date valid berita: {$publishedAndDateBerita}");
            
            $beritaPages = Berita::where('is_published', true)
                ->where('published_at', '<=', now())
                ->select('slug', 'updated_at')
                ->get()
                ->map(function ($berita) {
                    return [
                        'url' => url('/berita/' . $berita->slug),
                        'lastmod' => $berita->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.7'
                    ];
                });
        } catch (\Exception $e) {
            $this->warn('Error loading berita: ' . $e->getMessage());
        }

        $this->info('Added ' . $beritaPages->count() . ' berita pages');

        // Dynamic pages - Jurusan
        $jurusanPages = collect();
        try {
            $jurusanPages = Jurusan::where('is_active', true)
                ->select('singkatan', 'updated_at')
                ->get()
                ->map(function ($jurusan) {
                    $slug = Str::slug($jurusan->singkatan);
                    return [
                        'url' => url('/jurusan/' . $slug),
                        'lastmod' => $jurusan->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.8'
                    ];
                });
        } catch (\Exception $e) {
            $this->warn('Error loading jurusan: ' . $e->getMessage());
        }

        $this->info('Added ' . $jurusanPages->count() . ' jurusan pages');

        // Dynamic pages - Guru
        $guruPages = collect();
        try {
            $guruPages = Guru::where('is_active', true)
                ->select('id', 'nama', 'updated_at')
                ->get()
                ->map(function ($guru) {
                    return [
                        'url' => url('/guru/' . $guru->id),
                        'lastmod' => $guru->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.6'
                    ];
                });
        } catch (\Exception $e) {
            $this->warn('Error loading guru: ' . $e->getMessage());
        }

        $this->info('Added ' . $guruPages->count() . ' guru pages');

        // Dynamic pages - Prestasi
        $prestasiPages = collect();
        try {
            if (class_exists(Prestasi::class)) {
                $prestasiPages = Prestasi::where('is_published', true)
                    ->select('slug', 'updated_at')
                    ->get()
                    ->map(function ($prestasi) {
                        return [
                            'url' => url('/prestasi/' . $prestasi->slug),
                            'lastmod' => $prestasi->updated_at->format('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.6'
                        ];
                    });
            }
        } catch (\Exception $e) {
            $this->warn('Error loading prestasi: ' . $e->getMessage());
        }

        $this->info('Added ' . $prestasiPages->count() . ' prestasi pages');

        // Gabungkan semua pages
        $allPages = collect($staticPages)
            ->merge($beritaPages)
            ->merge($jurusanPages)
            ->merge($guruPages)
            ->merge($prestasiPages);

        // Generate XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($allPages as $page) {
            $xml .= "\t<url>\n";
            $xml .= "\t\t<loc>" . htmlspecialchars($page['url']) . "</loc>\n";
            $xml .= "\t\t<lastmod>" . $page['lastmod'] . "</lastmod>\n";
            $xml .= "\t\t<changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "\t\t<priority>" . $page['priority'] . "</priority>\n";
            $xml .= "\t</url>\n";
        }

        $xml .= '</urlset>';

        // Save to public/sitemap.xml
        File::put(public_path('sitemap.xml'), $xml);

        $this->info('Sitemap generated successfully!');
        $this->info('Total pages: ' . $allPages->count());
        $this->info('Location: ' . public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\Fasilitas;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index()
    {
        // Static pages dengan prioritas tinggi
        $staticPages = [
            [
                'url' => route('web.home'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'url' => route('web.profil.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'url' => route('web.profil.visi-misi'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => route('web.profil.akreditasi'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => route('web.profil.hubungan-industri'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'url' => route('web.profil.fasilitas'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => route('web.berita.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => route('web.jurusan.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.9'
            ],
            [
                'url' => route('web.guru.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'url' => route('web.prestasi.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'url' => route('web.ppdb.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.9'
            ],
            [
                'url' => route('web.contact.index'),
                'lastmod' => Carbon::now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
        ];

        // Dynamic pages - Berita
        $beritaPages = collect();
        try {
            $beritaPages = Berita::where('is_published', true)
                ->where('published_at', '<=', now())
                ->select('slug', 'updated_at')
                ->get()
                ->map(function ($berita) {
                    return [
                        'url' => route('web.berita.show', $berita->slug),
                        'lastmod' => $berita->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.7'
                    ];
                });
        } catch (\Exception $e) {
            \Log::error('Error loading berita for sitemap: ' . $e->getMessage());
        }

        // Dynamic pages - Jurusan (menggunakan singkatan sebagai slug)
        $jurusanPages = collect();
        try {
            $jurusanPages = Jurusan::where('is_active', true)
                ->select('singkatan', 'updated_at')
                ->get()
                ->map(function ($jurusan) {
                    $slug = Str::slug($jurusan->singkatan);
                    return [
                        'url' => route('web.jurusan.show', $slug),
                        'lastmod' => $jurusan->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.8'
                    ];
                });
        } catch (\Exception $e) {
            \Log::error('Error loading jurusan for sitemap: ' . $e->getMessage());
        }

        // Dynamic pages - Guru (menggunakan id karena tidak ada slug)
        $guruPages = collect();
        try {
            $guruPages = Guru::where('is_active', true)
                ->select('id', 'nama', 'updated_at')
                ->get()
                ->map(function ($guru) {
                    $slug = Str::slug($guru->nama);
                    return [
                        'url' => route('web.guru.show', $guru->id), // Gunakan ID jika tidak ada slug
                        'lastmod' => $guru->updated_at->format('Y-m-d'),
                        'changefreq' => 'monthly',
                        'priority' => '0.6'
                    ];
                });
        } catch (\Exception $e) {
            \Log::error('Error loading guru for sitemap: ' . $e->getMessage());
        }

        // Dynamic pages - Prestasi (cek apakah model ada)
        $prestasiPages = collect();
        if (class_exists(Prestasi::class)) {
            try {
                $prestasiPages = Prestasi::where('is_published', true)
                    ->select('slug', 'updated_at')
                    ->get()
                    ->map(function ($prestasi) {
                        return [
                            'url' => route('web.prestasi.show', $prestasi->slug),
                            'lastmod' => $prestasi->updated_at->format('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.6'
                        ];
                    });
            } catch (\Exception $e) {
                // Skip jika tabel tidak ada
            }
        }

        // Dynamic pages - Fasilitas (cek apakah model ada)
        $fasilitasPages = collect();
        if (class_exists(Fasilitas::class)) {
            try {
                $fasilitasPages = Fasilitas::where('is_active', true)
                    ->select('id', 'nama', 'updated_at')
                    ->get()
                    ->map(function ($fasilitas) {
                        $slug = Str::slug($fasilitas->nama);
                        return [
                            'url' => route('web.fasilitas.show', $slug),
                            'lastmod' => $fasilitas->updated_at->format('Y-m-d'),
                            'changefreq' => 'monthly',
                            'priority' => '0.6'
                        ];
                    });
            } catch (\Exception $e) {
                // Skip jika tabel tidak ada
            }
        }

        // Gabungkan semua pages
        $allPages = collect($staticPages)
            ->merge($beritaPages)
            ->merge($jurusanPages)
            ->merge($guruPages)
            ->merge($prestasiPages)
            ->merge($fasilitasPages);

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

return response($xml, 200)
->header('Content-Type', 'application/xml');
}
}
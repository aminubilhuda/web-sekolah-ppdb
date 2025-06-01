<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\Storage;

class InjectFavicon
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('content-type') === 'text/html') {
            $profil = ProfilSekolah::first();
            
            if ($profil && $profil->favicon) {
                $faviconUrl = Storage::url($profil->favicon);
                $content = $response->getContent();
                
                // Ganti favicon Laravel dengan favicon kustom
                $content = preg_replace(
                    '/<link rel="icon" type="image\/svg\+xml" href="[^"]+">/',
                    '<link rel="icon" type="image/x-icon" href="' . $faviconUrl . '">',
                    $content
                );
                
                $response->setContent($content);
            }
        }

        return $response;
    }
} 
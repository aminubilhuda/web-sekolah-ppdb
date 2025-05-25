<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::with('foto')
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view('web.galeri.index', compact('galeri'));
    }

    public function foto()
    {
        $galeris = Galeri::with('foto')
            ->where('status', true)
            ->where('jenis', 'foto')
            ->latest()
            ->paginate(12);
        return view('web.galeri.foto', compact('galeris'));
    }

    public function video()
    {
        $galeris = Galeri::with('foto')
            ->where('status', true)
            ->where('jenis', 'video')
            ->latest()
            ->paginate(12);
        return view('web.galeri.video', compact('galeris'));
    }

    public function show($id)
    {
        $galeri = Galeri::with('foto')->findOrFail($id);
        return view('web.galeri.show', compact('galeri'));
    }

    public function kategori($slug)
    {
        $galeris = Galeri::whereHas('kategori', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('kategori')->latest()->paginate(12);
        
        return view('web.galeri.kategori', compact('galeris'));
    }
} 
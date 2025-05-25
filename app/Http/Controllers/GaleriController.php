<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::with('kategori')->latest()->paginate(12);
        return view('galeri.index', compact('galeris'));
    }

    public function show(Galeri $galeri)
    {
        $galeri->load('kategori');
        return view('galeri.show', compact('galeri'));
    }

    public function kategori($slug)
    {
        $galeris = Galeri::whereHas('kategori', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('kategori')->latest()->paginate(12);
        
        return view('galeri.kategori', compact('galeris'));
    }
} 
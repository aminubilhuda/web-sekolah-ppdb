<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::with('kategori')->latest()->paginate(10);
        return view('prestasi.index', compact('prestasis'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load('kategori');
        return view('prestasi.show', compact('prestasi'));
    }

    public function kategori($slug)
    {
        $prestasis = Prestasi::whereHas('kategori', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('kategori')->latest()->paginate(10);
        
        return view('prestasi.kategori', compact('prestasis'));
    }
} 
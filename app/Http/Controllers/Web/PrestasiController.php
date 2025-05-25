<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\KategoriPrestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::with('kategori')
            ->where('status', true)
            ->latest()
            ->paginate(10);
        return view('web.prestasi.index', compact('prestasis'));
    }

    public function show($id)
    {
        $prestasi = Prestasi::with('kategori')->findOrFail($id);
        return view('web.prestasi.show', compact('prestasi'));
    }

    public function akademik()
    {
        $prestasis = Prestasi::whereHas('kategori', function($query) {
            $query->where('slug', 'akademik');
        })
        ->where('status', true)
        ->latest()
        ->paginate(10);
        
        return view('web.prestasi.akademik', compact('prestasis'));
    }

    public function nonAkademik()
    {
        $prestasis = Prestasi::whereHas('kategori', function($query) {
            $query->where('slug', 'non-akademik');
        })
        ->where('status', true)
        ->latest()
        ->paginate(10);
        
        return view('web.prestasi.non-akademik', compact('prestasis'));
    }
} 
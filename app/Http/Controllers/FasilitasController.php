<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $fasilitas = Fasilitas::active()
            ->orderBy('nama')
            ->paginate(12);
        
        return view('web.profil.fasilitas', compact('fasilitas'));
    }
    
    public function show($slug)
    {
        $fasilitas = Fasilitas::active()
            ->where('slug', $slug)
            ->firstOrFail();
            
        $fasilitasLainnya = Fasilitas::active()
            ->where('id', '!=', $fasilitas->id)
            ->orderBy('nama')
            ->limit(4)
            ->get();
            
        return view('web.fasilitas.show', compact('fasilitas', 'fasilitasLainnya'));
    }
}

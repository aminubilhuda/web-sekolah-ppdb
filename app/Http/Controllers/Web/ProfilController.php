<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return view('web.profil.index', compact('fasilitas'));
    }

    public function visiMisi()
    {
        $profil = \App\Models\ProfilSekolah::first();
        return view('web.profil.visi-misi', compact('profil'));
    }

    public function akreditasi()
    {
        $profil = \App\Models\ProfilSekolah::first();
        return view('web.profil.akreditasi', compact('profil'));
    }

    public function hubunganIndustri()
    {
        return view('web.profil.hubungan-industri');
    }

    public function fasilitas()
    {
        $fasilitas = Fasilitas::all();
        return view('web.profil.fasilitas', compact('fasilitas'));
    }
} 
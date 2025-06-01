<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\MitraIndustri;
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
        return view('web.profil.visi-misi');
    }

    public function akreditasi()
    {
        return view('web.profil.akreditasi');
    }

    public function hubunganIndustri()
    {
        $mitra = MitraIndustri::where('status', 'aktif')->get();
        $mitra_count = MitraIndustri::where('status', 'aktif')->count();
        $siswa_magang = 0; // Ini bisa disesuaikan dengan data sebenarnya
        $penyerapan = 0; // Ini bisa disesuaikan dengan data sebenarnya
        
        return view('web.profil.hubungan-industri', compact('mitra', 'mitra_count', 'siswa_magang', 'penyerapan'));
    }

    public function fasilitas()
    {
        $fasilitas = Fasilitas::all();
        return view('web.profil.fasilitas', compact('fasilitas'));
    }
} 
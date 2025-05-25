<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with('kepalaJurusan')->get();
        $profilSekolah = \App\Models\ProfilSekolah::first();
        return view('web.jurusan.index', compact('jurusans', 'profilSekolah'));
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load('kepalaJurusan', 'fasilitas');
        return view('web.jurusan.show', compact('jurusan'));
    }
} 
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
        return view('web.jurusan.index', compact('jurusans'));
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load('kepalaJurusan', 'fasilitas');
        return view('web.jurusan.show', compact('jurusan'));
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::with('kepalaJurusan')->get();
        return view('jurusan.index', compact('jurusans'));
    }

    public function show(Jurusan $jurusan)
    {
        $jurusan->load('kepalaJurusan', 'fasilitas');
        return view('jurusan.show', compact('jurusan'));
    }
} 
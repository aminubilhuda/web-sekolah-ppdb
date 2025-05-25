<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('jurusan')->paginate(12);
        return view('web.guru.index', compact('gurus'));
    }

    public function show(Guru $guru)
    {
        $guru->load('jurusan', 'ekstrakurikuler');
        return view('web.guru.show', compact('guru'));
    }
} 
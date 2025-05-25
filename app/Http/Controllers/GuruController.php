<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('jurusan')->get();
        return view('guru.index', compact('gurus'));
    }

    public function show(Guru $guru)
    {
        $guru->load('jurusan', 'ekstrakurikuler');
        return view('guru.show', compact('guru'));
    }
} 
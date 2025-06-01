<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::where('is_active', true)
            ->orderBy('nama')
            ->paginate(12);
            
        return view('web.guru.index', compact('gurus'));
    }

    public function show(Guru $guru)
    {
        // Hanya load guru tanpa relasi yang tidak ada
        return view('web.guru.show', compact('guru'));
    }
} 
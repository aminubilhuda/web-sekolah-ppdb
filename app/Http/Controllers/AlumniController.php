<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumnis = Alumni::with('jurusan')->latest()->paginate(12);
        return view('alumni.index', compact('alumnis'));
    }

    public function show(Alumni $alumni)
    {
        $alumni->load('jurusan');
        return view('alumni.show', compact('alumni'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $alumnis = Alumni::where('nama', 'like', "%{$query}%")
            ->orWhere('tahun_lulus', 'like', "%{$query}%")
            ->with('jurusan')
            ->paginate(12);
        
        return view('alumni.index', compact('alumnis', 'query'));
    }
} 
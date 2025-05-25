<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with('jurusan')->latest()->paginate(12);
        return view('web.alumni.index', compact('alumni'));
    }

    public function show(Alumni $alumni)
    {
        $alumni->load('jurusan');
        return view('web.alumni.show', compact('alumni'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $alumni = Alumni::where('nama', 'like', "%{$query}%")
            ->orWhere('tahun_lulus', 'like', "%{$query}%")
            ->with('jurusan')
            ->paginate(12);
        
        return view('web.alumni.index', compact('alumni', 'query'));
    }
} 
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::with('jurusan')->active();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Filter by jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('jurusan_id', $request->jurusan);
        }

        // Filter by tahun lulus
        if ($request->has('tahun_lulus') && $request->tahun_lulus != '') {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        $alumni = $query->latest()->paginate(12);
        $jurusan = Jurusan::all();
        $tahun_lulus = Alumni::select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        return view('web.alumni.index', compact('alumni', 'jurusan', 'tahun_lulus'));
    }

    public function show(Alumni $alumni)
    {
        $alumni->load('jurusan');
        return view('web.alumni.show', compact('alumni'));
    }

    public function testimoni()
    {
        $testimoni = Alumni::with('jurusan')
            ->active()
            ->whereNotNull('testimoni')
            ->latest()
            ->paginate(12);
        
        return view('web.alumni.testimoni', compact('testimoni'));
    }

    public function bekerja()
    {
        $bekerja = Alumni::with('jurusan')
            ->active()
            ->bekerja()
            ->latest()
            ->paginate(12);
        
        return view('web.alumni.bekerja', compact('bekerja'));
    }

    public function kuliah()
    {
        $kuliah = Alumni::with('jurusan')
            ->active()
            ->kuliah()
            ->latest()
            ->paginate(12);
        
        return view('web.alumni.kuliah', compact('kuliah'));
    }
} 
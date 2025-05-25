<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::with('jurusan')->active()->get();
        return response()->json($alumni);
    }

    public function show($id)
    {
        $alumni = Alumni::with('jurusan')->findOrFail($id);
        return response()->json($alumni);
    }

    public function testimoni()
    {
        $testimoni = Alumni::with('jurusan')
            ->active()
            ->whereNotNull('testimoni')
            ->get();
        return response()->json($testimoni);
    }

    public function bekerja()
    {
        $bekerja = Alumni::with('jurusan')
            ->active()
            ->bekerja()
            ->get();
        return response()->json($bekerja);
    }

    public function kuliah()
    {
        $kuliah = Alumni::with('jurusan')
            ->active()
            ->kuliah()
            ->get();
        return response()->json($kuliah);
    }

    public function byJurusan($jurusan_id)
    {
        $alumni = Alumni::with('jurusan')
            ->active()
            ->where('jurusan_id', $jurusan_id)
            ->get();
        return response()->json($alumni);
    }

    public function byTahunLulus($tahun)
    {
        $alumni = Alumni::with('jurusan')
            ->active()
            ->where('tahun_lulus', $tahun)
            ->get();
        return response()->json($alumni);
    }
} 
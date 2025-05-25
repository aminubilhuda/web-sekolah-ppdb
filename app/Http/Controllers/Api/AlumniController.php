<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::where('status', true)->get();
        return response()->json($alumni);
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return response()->json($alumni);
    }

    public function testimoni()
    {
        $testimoni = Alumni::where('status', true)
            ->whereNotNull('testimoni')
            ->get();
        return response()->json($testimoni);
    }

    public function bekerja()
    {
        $bekerja = Alumni::where('status', true)
            ->whereNotNull('tempat_kerja')
            ->get();
        return response()->json($bekerja);
    }
} 
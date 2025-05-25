<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($berita);
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }
} 
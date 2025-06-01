<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BeritaController extends Controller
{
    public function index()
    {
        // Enable query logging
        DB::enableQueryLog();

        $berita = Berita::with('kategori')
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest()
            ->paginate(9);

        // Log the query
        Log::info('Berita Query:', [
            'sql' => DB::getQueryLog(),
            'count' => $berita->count(),
            'first_item' => $berita->first() ? $berita->first()->toArray() : null
        ]);

        return view('web.berita.index', compact('berita'));
    }

    public function show($slug)
    {
        $berita = Berita::with('kategori')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $beritaTerbaru = Berita::with('kategori')
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where('id', '!=', $berita->id)
            ->latest()
            ->take(3)
            ->get();

        $kategoris = Kategori::withCount('berita')
            ->orderBy('nama')
            ->get();

        return view('web.berita.show', compact('berita', 'beritaTerbaru', 'kategoris'));
    }
} 
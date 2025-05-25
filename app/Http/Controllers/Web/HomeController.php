<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_published', true)->get();
        $latestNews = Berita::where('status', true)->latest()->take(4)->get();
        $profilSekolah = \App\Models\ProfilSekolah::first();
        return view('web.home', compact('sliders', 'latestNews', 'profilSekolah'));
    }
} 
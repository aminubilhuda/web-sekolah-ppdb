<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Jurusan;
use App\Models\Slider;
use App\Models\Guru;
use App\Models\Alumni;
use App\Models\Siswa;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_published', true)->get();
        $latestNews = Berita::where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest()
            ->take(4)
            ->get();
        $fasilitas = Fasilitas::active()->take(4)->get();
        
        // Ambil profil sekolah untuk banner highlight
        $profilSekolah = ProfilSekolah::first();
        
        // Ambil data statistik real dari database
        $totalAlumni = Alumni::where('status', true)->count();
        $totalGuru = Guru::where('is_active', true)->count();
        $totalJurusan = Jurusan::where('is_active', true)->count();
        
        // Hitung tingkat kelulusan (persentase alumni yang bekerja atau kuliah)
        $alumniSukses = Alumni::where('status', true)
            ->where(function($query) {
                $query->where('status_bekerja', true)
                      ->orWhere('status_kuliah', true);
            })->count();
        
        $tingkatKelulusan = $totalAlumni > 0 ? round(($alumniSukses / $totalAlumni) * 100) : 0;
        
        $stats = [
            'alumni' => $totalAlumni,
            'guru' => $totalGuru, 
            'jurusan' => $totalJurusan,
            'kelulusan' => $tingkatKelulusan
        ];
        
        // Ambil data jurusan untuk section programs
        $jurusans = Jurusan::with('kepalaJurusan')->where('is_active', true)->take(3)->get();
        
        return view('web.home', compact('sliders', 'latestNews', 'fasilitas', 'stats', 'jurusans', 'profilSekolah'));
    }
} 
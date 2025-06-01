<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProfilController;
use App\Http\Controllers\Web\BeritaController;
use App\Http\Controllers\Web\AgendaController;
use App\Http\Controllers\Web\JurusanController;
use App\Http\Controllers\Web\EkstrakurikulerController;
use App\Http\Controllers\Web\AlumniController;
use App\Http\Controllers\Web\GuruController;
use App\Http\Controllers\Web\PPDBController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\GaleriController;
use App\Http\Controllers\Web\PrestasiController;
use App\Http\Controllers\Web\FaqController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Web\MitraIndustriController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', [HomeController::class, 'index'])->name('web.home');

// Profil
Route::prefix('profil')->name('web.profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/akreditasi', [ProfilController::class, 'akreditasi'])->name('akreditasi');
    Route::get('/hubungan-industri', [ProfilController::class, 'hubunganIndustri'])->name('hubungan-industri');
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');
});

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('web.berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('web.berita.show');

// Agenda
Route::get('/agenda', [AgendaController::class, 'index'])->name('web.agenda.index');
Route::get('/agenda/{agenda}', [AgendaController::class, 'show'])->name('web.agenda.show');

// Jurusan
Route::get('/jurusan', [JurusanController::class, 'index'])->name('web.jurusan.index');
Route::get('/jurusan/{jurusan}', [JurusanController::class, 'show'])->name('web.jurusan.show');

// Ekstrakurikuler
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('web.ekstrakurikuler.index');
Route::get('/ekstrakurikuler/{ekstrakurikuler}', [EkstrakurikulerController::class, 'show'])->name('web.ekstrakurikuler.show');

// Alumni
Route::prefix('alumni')->name('web.alumni.')->group(function () {
    Route::get('/', [AlumniController::class, 'index'])->name('index');
    Route::get('/testimoni', [AlumniController::class, 'testimoni'])->name('testimoni');
    Route::get('/bekerja', [AlumniController::class, 'bekerja'])->name('bekerja');
    Route::get('/kuliah', [AlumniController::class, 'kuliah'])->name('kuliah');
    Route::get('/{alumni}', [AlumniController::class, 'show'])->name('show');
});

// Guru
Route::get('/guru', [GuruController::class, 'index'])->name('web.guru.index');
Route::get('/guru/{guru}', [GuruController::class, 'show'])->name('web.guru.show');

// PPDB
Route::prefix('ppdb')->name('web.ppdb.')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('index');
    Route::get('/form', [PPDBController::class, 'form'])->name('form');
    Route::post('/store', [PPDBController::class, 'store'])->name('store');
    Route::get('/success', [PPDBController::class, 'success'])->name('success');
    Route::get('/status', [PPDBController::class, 'status'])->name('status');
    Route::get('/check', [PPDBController::class, 'check'])->name('check');
    Route::get('/panduan', [PPDBController::class, 'panduan'])->name('panduan');
});

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('web.contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('web.contact.store');

// Galeri
Route::prefix('galeri')->name('web.galeri.')->group(function () {
    Route::get('/', [GaleriController::class, 'index'])->name('index');
    Route::get('/foto', [GaleriController::class, 'foto'])->name('foto');
    Route::get('/video', [GaleriController::class, 'video'])->name('video');
    Route::get('/{id}', [GaleriController::class, 'show'])->name('show');
});

// Prestasi
Route::prefix('prestasi')->name('web.prestasi.')->group(function () {
    Route::get('/', [PrestasiController::class, 'index'])->name('index');
    Route::get('/akademik', [PrestasiController::class, 'akademik'])->name('akademik');
    Route::get('/non-akademik', [PrestasiController::class, 'nonAkademik'])->name('non-akademik');
    Route::get('/{id}', [PrestasiController::class, 'show'])->name('show');
});

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404);
    }
    
    return response()->file($fullPath)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
})->where('path', '.*');

Route::get('/galeri', [App\Http\Controllers\Web\GaleriController::class, 'index'])->name('web.galeri.index');

// Fasilitas Routes
Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
    Route::get('/', [FasilitasController::class, 'index'])->name('index');
    Route::get('/{slug}', [FasilitasController::class, 'show'])->name('show');
});
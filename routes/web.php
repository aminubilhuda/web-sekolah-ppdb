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
use App\Http\Controllers\Web\SiswaController;
use App\Http\Controllers\Web\PPDBController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\GaleriController;
use App\Http\Controllers\Web\PrestasiController;
use App\Http\Controllers\Web\FaqController;
use App\Http\Controllers\Web\DownloadController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', [HomeController::class, 'index'])->name('web.home');

// Profil
Route::prefix('profil')->name('web.profil.')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/akreditasi', [ProfilController::class, 'akreditasi'])->name('akreditasi');
    Route::get('/hubungan-industri', [ProfilController::class, 'hubunganIndustri'])->name('hubungan-industri');
    Route::get('/fasilitas', [ProfilController::class, 'fasilitas'])->name('fasilitas');
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
Route::get('/alumni', [AlumniController::class, 'index'])->name('web.alumni.index');
Route::get('/alumni/search', [AlumniController::class, 'search'])->name('web.alumni.search');
Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('web.alumni.show');

// Guru
Route::get('/guru', [GuruController::class, 'index'])->name('web.guru.index');
Route::get('/guru/{guru}', [GuruController::class, 'show'])->name('web.guru.show');

// Siswa
Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');

// PPDB
Route::get('/ppdb', [PPDBController::class, 'index'])->name('web.ppdb.index');
Route::get('/ppdb/form', [PPDBController::class, 'form'])->name('web.ppdb.form');
Route::post('/ppdb/store', [PPDBController::class, 'store'])->name('web.ppdb.store');
Route::get('/ppdb/status', [PPDBController::class, 'status'])->name('web.ppdb.status');
Route::get('/ppdb/panduan', [PPDBController::class, 'panduan'])->name('web.ppdb.panduan');

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

// Download
Route::prefix('download')->group(function () {
    Route::get('/', [DownloadController::class, 'index'])->name('download');
    Route::get('/formulir', [DownloadController::class, 'formulir'])->name('download.formulir');
    Route::get('/dokumen', [DownloadController::class, 'dokumen'])->name('download.dokumen');
});

Route::get('/profil', [ProfilController::class, 'index'])->name('web.profil.index');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Guru Management
    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\GuruController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\GuruController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Admin\GuruController::class, 'store'])->name('store');
        Route::get('/{guru}/edit', [App\Http\Controllers\Admin\GuruController::class, 'edit'])->name('edit');
        Route::put('/{guru}', [App\Http\Controllers\Admin\GuruController::class, 'update'])->name('update');
        Route::delete('/{guru}', [App\Http\Controllers\Admin\GuruController::class, 'destroy'])->name('destroy');
    });
});

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
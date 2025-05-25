<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfilSekolahController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\JurusanController;
use App\Http\Controllers\Api\EkstrakurikulerController;
use App\Http\Controllers\Api\AlumniController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\PpdbController;
use App\Http\Controllers\Api\GaleriController;
use App\Http\Controllers\Api\PrestasiController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Profil Sekolah
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'index']);

// Berita
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);

// Agenda
Route::get('/agenda', [AgendaController::class, 'index']);
Route::get('/agenda/{id}', [AgendaController::class, 'show']);

// Jurusan
Route::get('/jurusan', [JurusanController::class, 'index']);
Route::get('/jurusan/{id}', [JurusanController::class, 'show']);

// Ekstrakurikuler
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index']);
Route::get('/ekstrakurikuler/{id}', [EkstrakurikulerController::class, 'show']);

// Alumni
Route::get('/alumni', [AlumniController::class, 'index']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::get('/alumni/testimoni', [AlumniController::class, 'testimoni']);
Route::get('/alumni/bekerja', [AlumniController::class, 'bekerja']);

// Guru
Route::get('/guru', [GuruController::class, 'index']);
Route::get('/guru/{id}', [GuruController::class, 'show']);

// Siswa
Route::get('/siswa', [SiswaController::class, 'index']);
Route::get('/siswa/{id}', [SiswaController::class, 'show']);

// PPDB
Route::post('/ppdb', [PpdbController::class, 'store']);
Route::post('/ppdb/check-status', [PpdbController::class, 'checkStatus']);

// Galeri
Route::prefix('galeri')->group(function () {
    Route::get('/', [GaleriController::class, 'index']);
    Route::get('/foto', [GaleriController::class, 'foto']);
    Route::get('/video', [GaleriController::class, 'video']);
    Route::get('/{id}', [GaleriController::class, 'show']);
});

// Prestasi
Route::prefix('prestasi')->group(function () {
    Route::get('/', [PrestasiController::class, 'index']);
    Route::get('/akademik', [PrestasiController::class, 'akademik']);
    Route::get('/non-akademik', [PrestasiController::class, 'nonAkademik']);
    Route::get('/{id}', [PrestasiController::class, 'show']);
});

// FAQ
Route::get('/faq', [FaqController::class, 'index']);

// Download
Route::prefix('download')->group(function () {
    Route::get('/', [DownloadController::class, 'index']);
    Route::get('/formulir', [DownloadController::class, 'formulir']);
    Route::get('/dokumen', [DownloadController::class, 'dokumen']);
});

// Contact
Route::post('/contact', [ContactController::class, 'store']); 
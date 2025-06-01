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
use App\Http\Controllers\Api\Lk3Controller;
use App\Http\Controllers\Api\GeminiController;

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

Route::middleware('api')->group(function () {
    // Profil Sekolah CRUD
    Route::apiResource('profil-sekolah', ProfilSekolahController::class);
    
    // Berita CRUD
    Route::apiResource('berita', BeritaController::class);
    
    // Agenda CRUD
    Route::apiResource('agenda', AgendaController::class);
    
    // Jurusan CRUD
    Route::apiResource('jurusan', JurusanController::class);
    
    // Ekstrakurikuler CRUD
    Route::apiResource('ekstrakurikuler', EkstrakurikulerController::class);
    
    // Alumni CRUD
    Route::apiResource('alumni', AlumniController::class);
    Route::get('/alumni/testimoni', [AlumniController::class, 'testimoni']);
    Route::get('/alumni/bekerja', [AlumniController::class, 'bekerja']);
    Route::get('/alumni/kuliah', [AlumniController::class, 'kuliah']);
    Route::get('/alumni/jurusan/{jurusan_id}', [AlumniController::class, 'byJurusan']);
    Route::get('/alumni/tahun/{tahun}', [AlumniController::class, 'byTahunLulus']);
    
    // Guru CRUD
    Route::apiResource('guru', GuruController::class);
    
    // Siswa CRUD
    Route::apiResource('siswa', SiswaController::class);
    
    // PPDB
    Route::post('/ppdb', [PpdbController::class, 'store']);
    Route::post('/ppdb/check-status', [PpdbController::class, 'checkStatus']);
    
    // Galeri CRUD
    Route::apiResource('galeri', GaleriController::class);
    Route::get('/galeri/foto', [GaleriController::class, 'foto']);
    Route::get('/galeri/video', [GaleriController::class, 'video']);
    
    // Prestasi CRUD
    Route::apiResource('prestasi', PrestasiController::class);
    Route::get('/prestasi/akademik', [PrestasiController::class, 'akademik']);
    Route::get('/prestasi/non-akademik', [PrestasiController::class, 'nonAkademik']);
    
    // FAQ CRUD
    Route::apiResource('faq', FaqController::class);
    
    // Download CRUD
    Route::apiResource('download', DownloadController::class);
    Route::get('/download/formulir', [DownloadController::class, 'formulir']);
    Route::get('/download/dokumen', [DownloadController::class, 'dokumen']);
    
    // Contact
    Route::post('/contact', [ContactController::class, 'store']);
    
    // LK3 CRUD
    Route::apiResource('lk3', Lk3Controller::class);

    // Gemini AI Routes - Inspired by techsolutionstuff.com tutorial
    Route::prefix('gemini')->group(function () {
        Route::get('/test', [GeminiController::class, 'test']);
        Route::get('/models', [GeminiController::class, 'models']);
        Route::post('/generate', [GeminiController::class, 'generate']);
        Route::post('/generate-advanced', [GeminiController::class, 'generateAdvanced']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
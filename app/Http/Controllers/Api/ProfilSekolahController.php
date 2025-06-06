<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use App\Services\CacheService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProfilSekolahController extends Controller
{
    /**
     * Menampilkan semua data profil sekolah
     */
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data profil sekolah');
            $profil = CacheService::getProfilSekolah();
            
            if (!$profil) {
                Log::warning('Data profil sekolah tidak ditemukan');
                return ResponseService::notFound('Data profil sekolah tidak ditemukan');
            }
            
            Log::info('Data profil sekolah berhasil diambil', ['data' => $profil]);
            return ResponseService::success($profil, 'Data profil sekolah berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data profil sekolah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data profil sekolah');
        }
    }

    /**
     * Menyimpan data profil sekolah baru
     */
    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan data profil sekolah baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_sekolah' => 'required|string|max:255',
                'npsn' => 'required|string|max:20',
                'status' => 'required|string|in:negeri,swasta',
                'jenis' => 'required|string|in:smk,sma,smk',
                'status_akreditasi' => 'required|string|in:a,b,c',
                'kepala_sekolah' => 'required|string|max:255',
                'sambutan_kepala' => 'required|string',
                'sejarah' => 'required|string',
                'visi' => 'required|string',
                'misi' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'email' => 'required|email|max:255',
                'no_hp' => 'required|string|max:20',
                'alamat' => 'required|string',
                'provinsi' => 'required|string|max:100',
                'kabupaten' => 'required|string|max:100',
                'kecamatan' => 'required|string|max:100',
                'kode_pos' => 'required|string|max:10',
                'website' => 'nullable|url|max:255',
                'lokasi_maps' => 'nullable|string',
                'sk_pendirian' => 'nullable|string',
                'sk_izin_operasional' => 'nullable|string',
                'video_profile' => 'nullable|string',
                'facebook' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'twitter' => 'nullable|string|max:255',
                'youtube' => 'nullable|string|max:255',
                'tiktok' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'telegram' => 'nullable|string|max:255',
                'banner_highlight' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $profil = ProfilSekolah::create($request->all());
            
            Log::info('Data profil sekolah berhasil disimpan', ['data' => $profil]);
            return ResponseService::success($profil, 'Data profil sekolah berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan data profil sekolah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan data profil sekolah');
        }
    }

    /**
     * Menampilkan detail profil sekolah
     */
    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail profil sekolah', ['id' => $id]);
            $profil = ProfilSekolah::find($id);
            
            if (!$profil) {
                Log::warning('Data profil sekolah tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data profil sekolah tidak ditemukan');
            }
            
            Log::info('Detail profil sekolah berhasil diambil', ['data' => $profil]);
            return ResponseService::success($profil, 'Detail profil sekolah berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail profil sekolah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail profil sekolah');
        }
    }

    /**
     * Mengupdate data profil sekolah
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate data profil sekolah', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_sekolah' => 'sometimes|required|string|max:255',
                'npsn' => 'sometimes|required|string|max:20',
                'status' => 'sometimes|required|string|in:negeri,swasta',
                'jenis' => 'sometimes|required|string|in:smk,sma,smk',
                'status_akreditasi' => 'sometimes|required|string|in:a,b,c',
                'kepala_sekolah' => 'sometimes|required|string|max:255',
                'sambutan_kepala' => 'sometimes|required|string',
                'sejarah' => 'sometimes|required|string',
                'visi' => 'sometimes|required|string',
                'misi' => 'sometimes|required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'favicon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'email' => 'sometimes|required|email|max:255',
                'no_hp' => 'sometimes|required|string|max:20',
                'alamat' => 'sometimes|required|string',
                'provinsi' => 'sometimes|required|string|max:100',
                'kabupaten' => 'sometimes|required|string|max:100',
                'kecamatan' => 'sometimes|required|string|max:100',
                'kode_pos' => 'sometimes|required|string|max:10',
                'website' => 'nullable|url|max:255',
                'lokasi_maps' => 'nullable|string',
                'sk_pendirian' => 'nullable|string',
                'sk_izin_operasional' => 'nullable|string',
                'video_profile' => 'nullable|string',
                'facebook' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'twitter' => 'nullable|string|max:255',
                'youtube' => 'nullable|string|max:255',
                'tiktok' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'telegram' => 'nullable|string|max:255',
                'banner_highlight' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $profil = ProfilSekolah::find($id);
            
            if (!$profil) {
                Log::warning('Data profil sekolah tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data profil sekolah tidak ditemukan');
            }

            $profil->update($request->all());
            
            Log::info('Data profil sekolah berhasil diupdate', ['data' => $profil]);
            return ResponseService::success($profil, 'Data profil sekolah berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate data profil sekolah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate data profil sekolah');
        }
    }

    /**
     * Menghapus data profil sekolah
     */
    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus data profil sekolah', ['id' => $id]);
            $profil = ProfilSekolah::find($id);
            
            if (!$profil) {
                Log::warning('Data profil sekolah tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data profil sekolah tidak ditemukan');
            }

            $profil->delete();
            
            Log::info('Data profil sekolah berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Data profil sekolah berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus data profil sekolah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus data profil sekolah');
        }
    }
} 
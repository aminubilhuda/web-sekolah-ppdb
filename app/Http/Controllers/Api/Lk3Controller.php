<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lk3;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Lk3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data LK3');
            $lk3 = Lk3::where('status', 'published')->orderBy('tahun', 'desc')->get();
            
            Log::info('Data LK3 berhasil diambil', ['count' => $lk3->count()]);
            return ResponseService::success($lk3, 'Data LK3 berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data LK3: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data LK3');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan data LK3 baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
                'tahun' => 'required|string|size:4',
                'status' => 'required|in:draft,published'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $file = $request->file('file');
            $filePath = $file->store('lk3', 'public');

            $lk3 = Lk3::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath,
                'tahun' => $request->tahun,
                'status' => $request->status
            ]);
            
            Log::info('Data LK3 berhasil disimpan', ['data' => $lk3]);
            return ResponseService::success($lk3, 'Data LK3 berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan data LK3: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan data LK3');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail LK3', ['id' => $id]);
            $lk3 = Lk3::find($id);
            
            if (!$lk3) {
                Log::warning('Data LK3 tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data LK3 tidak ditemukan');
            }
            
            Log::info('Detail LK3 berhasil diambil', ['data' => $lk3]);
            return ResponseService::success($lk3, 'Detail LK3 berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail LK3: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail LK3');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate data LK3', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'sometimes|required|string|max:255',
                'deskripsi' => 'nullable|string',
                'file' => 'sometimes|required|file|mimes:pdf,doc,docx|max:10240',
                'tahun' => 'sometimes|required|string|size:4',
                'status' => 'sometimes|required|in:draft,published'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $lk3 = Lk3::find($id);
            
            if (!$lk3) {
                Log::warning('Data LK3 tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data LK3 tidak ditemukan');
            }

            if ($request->hasFile('file')) {
                // Hapus file lama
                Storage::disk('public')->delete($lk3->file_path);
                
                // Upload file baru
                $file = $request->file('file');
                $filePath = $file->store('lk3', 'public');
                $lk3->file_path = $filePath;
            }

            $lk3->update($request->except('file'));
            
            Log::info('Data LK3 berhasil diupdate', ['data' => $lk3]);
            return ResponseService::success($lk3, 'Data LK3 berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate data LK3: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate data LK3');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus data LK3', ['id' => $id]);
            $lk3 = Lk3::find($id);
            
            if (!$lk3) {
                Log::warning('Data LK3 tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Data LK3 tidak ditemukan');
            }

            // Hapus file
            Storage::disk('public')->delete($lk3->file_path);
            
            $lk3->delete();
            
            Log::info('Data LK3 berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Data LK3 berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus data LK3: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus data LK3');
        }
    }
}

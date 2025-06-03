<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data ekstrakurikuler');
            $ekstrakurikuler = Ekstrakurikuler::where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data ekstrakurikuler berhasil diambil', ['count' => $ekstrakurikuler->count()]);
            return ResponseService::success($ekstrakurikuler, 'Data ekstrakurikuler berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data ekstrakurikuler: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data ekstrakurikuler');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan ekstrakurikuler baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'pembina' => 'required|string|max:255',
                'hari' => 'required|string|max:50',
                'jam' => 'required|string|max:50',
                'tempat' => 'required|string|max:255',
                'kuota' => 'required|integer|min:1',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('ekstrakurikuler', 'public');
            }

            $ekstrakurikuler = Ekstrakurikuler::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambarPath ?? null,
                'pembina' => $request->pembina,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'tempat' => $request->tempat,
                'kuota' => $request->kuota,
                'status' => $request->status
            ]);
            
            Log::info('Ekstrakurikuler berhasil disimpan', ['data' => $ekstrakurikuler]);
            return ResponseService::success($ekstrakurikuler, 'Ekstrakurikuler berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan ekstrakurikuler: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan ekstrakurikuler');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail ekstrakurikuler', ['id' => $id]);
            $ekstrakurikuler = Ekstrakurikuler::find($id);
            
            if (!$ekstrakurikuler) {
                Log::warning('Ekstrakurikuler tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Ekstrakurikuler tidak ditemukan');
            }
            
            Log::info('Detail ekstrakurikuler berhasil diambil', ['data' => $ekstrakurikuler]);
            return ResponseService::success($ekstrakurikuler, 'Detail ekstrakurikuler berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail ekstrakurikuler: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail ekstrakurikuler');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate ekstrakurikuler', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:255',
                'deskripsi' => 'sometimes|required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'pembina' => 'sometimes|required|string|max:255',
                'hari' => 'sometimes|required|string|max:50',
                'jam' => 'sometimes|required|string|max:50',
                'tempat' => 'sometimes|required|string|max:255',
                'kuota' => 'sometimes|required|integer|min:1',
                'status' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $ekstrakurikuler = Ekstrakurikuler::find($id);
            
            if (!$ekstrakurikuler) {
                Log::warning('Ekstrakurikuler tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Ekstrakurikuler tidak ditemukan');
            }

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($ekstrakurikuler->gambar) {
                    Storage::disk('public')->delete($ekstrakurikuler->gambar);
                }
                
                // Upload gambar baru
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('ekstrakurikuler', 'public');
                $ekstrakurikuler->gambar = $gambarPath;
            }

            $ekstrakurikuler->update($request->except('gambar'));
            
            Log::info('Ekstrakurikuler berhasil diupdate', ['data' => $ekstrakurikuler]);
            return ResponseService::success($ekstrakurikuler, 'Ekstrakurikuler berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate ekstrakurikuler: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate ekstrakurikuler');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus ekstrakurikuler', ['id' => $id]);
            $ekstrakurikuler = Ekstrakurikuler::find($id);
            
            if (!$ekstrakurikuler) {
                Log::warning('Ekstrakurikuler tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Ekstrakurikuler tidak ditemukan');
            }

            // Hapus gambar
            if ($ekstrakurikuler->gambar) {
                Storage::disk('public')->delete($ekstrakurikuler->gambar);
            }
            
            $ekstrakurikuler->delete();
            
            Log::info('Ekstrakurikuler berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Ekstrakurikuler berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus ekstrakurikuler: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus ekstrakurikuler');
        }
    }
} 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data jurusan');
            $jurusan = Jurusan::with('kepalaJurusan')
                ->where('is_active', true)
                ->orderBy('nama_jurusan', 'asc')
                ->get();
            
            Log::info('Data jurusan berhasil diambil', ['count' => $jurusan->count()]);
            return ResponseService::success($jurusan, 'Data jurusan berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data jurusan');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan jurusan baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'required|string|max:255',
                'singkatan' => 'required|string|max:10',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kepala_jurusan_id' => 'nullable|exists:guru,id',
                'is_active' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('jurusan', 'public');
            }

            $jurusan = Jurusan::create([
                'nama_jurusan' => $request->nama_jurusan,
                'singkatan' => $request->singkatan,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambarPath ?? null,
                'kepala_jurusan_id' => $request->kepala_jurusan_id,
                'is_active' => $request->is_active
            ]);
            
            Log::info('Jurusan berhasil disimpan', ['data' => $jurusan]);
            return ResponseService::success($jurusan, 'Jurusan berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan jurusan');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail jurusan', ['id' => $id]);
            $jurusan = Jurusan::with('kepalaJurusan')->find($id);
            
            if (!$jurusan) {
                Log::warning('Jurusan tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Jurusan tidak ditemukan');
            }
            
            Log::info('Detail jurusan berhasil diambil', ['data' => $jurusan]);
            return ResponseService::success($jurusan, 'Detail jurusan berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail jurusan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate jurusan', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_jurusan' => 'sometimes|required|string|max:255',
                'singkatan' => 'sometimes|required|string|max:10',
                'deskripsi' => 'sometimes|required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kepala_jurusan_id' => 'nullable|exists:guru,id',
                'is_active' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $jurusan = Jurusan::find($id);
            
            if (!$jurusan) {
                Log::warning('Jurusan tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Jurusan tidak ditemukan');
            }

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($jurusan->gambar) {
                    Storage::disk('public')->delete($jurusan->gambar);
                }
                
                // Upload gambar baru
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('jurusan', 'public');
                $jurusan->gambar = $gambarPath;
            }

            $jurusan->update($request->except('gambar'));
            
            Log::info('Jurusan berhasil diupdate', ['data' => $jurusan]);
            return ResponseService::success($jurusan, 'Jurusan berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate jurusan');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus jurusan', ['id' => $id]);
            $jurusan = Jurusan::find($id);
            
            if (!$jurusan) {
                Log::warning('Jurusan tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Jurusan tidak ditemukan');
            }

            // Hapus gambar
            if ($jurusan->gambar) {
                Storage::disk('public')->delete($jurusan->gambar);
            }
            
            $jurusan->delete();
            
            Log::info('Jurusan berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Jurusan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus jurusan');
        }
    }
} 
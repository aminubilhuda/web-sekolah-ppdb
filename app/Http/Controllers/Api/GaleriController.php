<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data galeri');
            $galeri = Galeri::where('is_active', true)
                ->latest()
                ->get();
            
            Log::info('Data galeri berhasil diambil', ['count' => $galeri->count()]);
            return ResponseService::success($galeri, 'Data galeri berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data galeri: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data galeri');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan galeri baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tipe' => 'required|in:foto,video',
                'file' => 'required|file|max:10240', // max 10MB
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $data = $request->except('file');
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                
                // Validasi ekstensi file berdasarkan tipe
                if ($request->tipe === 'foto' && !in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    return ResponseService::validationError(['file' => ['File harus berupa gambar (jpg, jpeg, png)']]);
                }
                
                if ($request->tipe === 'video' && !in_array($extension, ['mp4', 'avi', 'mov'])) {
                    return ResponseService::validationError(['file' => ['File harus berupa video (mp4, avi, mov)']]);
                }
                
                $data['file'] = $file->store('galeri/' . $request->tipe, 'public');
            }

            $galeri = Galeri::create($data);
            
            Log::info('Galeri berhasil disimpan', ['data' => $galeri]);
            return ResponseService::success($galeri, 'Galeri berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan galeri: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan galeri');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail galeri', ['id' => $id]);
            $galeri = Galeri::where('is_active', true)->find($id);
            
            if (!$galeri) {
                Log::warning('Galeri tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Galeri tidak ditemukan');
            }
            
            Log::info('Detail galeri berhasil diambil', ['data' => $galeri]);
            return ResponseService::success($galeri, 'Detail galeri berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail galeri: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail galeri');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate galeri', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'sometimes|required|string|max:255',
                'deskripsi' => 'sometimes|required|string',
                'tipe' => 'sometimes|required|in:foto,video',
                'file' => 'nullable|file|max:10240', // max 10MB
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $galeri = Galeri::find($id);
            
            if (!$galeri) {
                Log::warning('Galeri tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Galeri tidak ditemukan');
            }

            $data = $request->except('file');

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                
                // Validasi ekstensi file berdasarkan tipe
                if ($request->tipe === 'foto' && !in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    return ResponseService::validationError(['file' => ['File harus berupa gambar (jpg, jpeg, png)']]);
                }
                
                if ($request->tipe === 'video' && !in_array($extension, ['mp4', 'avi', 'mov'])) {
                    return ResponseService::validationError(['file' => ['File harus berupa video (mp4, avi, mov)']]);
                }
                
                // Hapus file lama
                if ($galeri->file) {
                    Storage::disk('public')->delete($galeri->file);
                }
                
                $data['file'] = $file->store('galeri/' . $request->tipe, 'public');
            }

            $galeri->update($data);
            
            Log::info('Galeri berhasil diupdate', ['data' => $galeri]);
            return ResponseService::success($galeri, 'Galeri berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate galeri: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate galeri');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus galeri', ['id' => $id]);
            $galeri = Galeri::find($id);
            
            if (!$galeri) {
                Log::warning('Galeri tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Galeri tidak ditemukan');
            }

            // Hapus file
            if ($galeri->file) {
                Storage::disk('public')->delete($galeri->file);
            }
            
            $galeri->delete();
            
            Log::info('Galeri berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Galeri berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus galeri: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus galeri');
        }
    }

    public function foto()
    {
        try {
            Log::info('Mencoba mengambil data galeri foto');
            $galeri = Galeri::where('is_active', true)
                ->where('tipe', 'foto')
                ->latest()
                ->get();
            
            Log::info('Data galeri foto berhasil diambil', ['count' => $galeri->count()]);
            return ResponseService::success($galeri, 'Data galeri foto berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data galeri foto: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data galeri foto');
        }
    }

    public function video()
    {
        try {
            Log::info('Mencoba mengambil data galeri video');
            $galeri = Galeri::where('is_active', true)
                ->where('tipe', 'video')
                ->latest()
                ->get();
            
            Log::info('Data galeri video berhasil diambil', ['count' => $galeri->count()]);
            return ResponseService::success($galeri, 'Data galeri video berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data galeri video: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data galeri video');
        }
    }
} 
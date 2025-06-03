<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengumumanController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data pengumuman');
            $pengumuman = Pengumuman::where('is_published', true)
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->get();
            
            Log::info('Data pengumuman berhasil diambil', ['count' => $pengumuman->count()]);
            return ResponseService::success($pengumuman, 'Data pengumuman berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data pengumuman: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data pengumuman');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan pengumuman baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_published' => 'required|boolean',
                'published_at' => 'nullable|date',
                'tanggal_selesai' => 'required|date|after_or_equal:published_at'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('pengumuman', 'public');
            }

            $pengumuman = Pengumuman::create([
                'judul' => $request->judul,
                'slug' => \Str::slug($request->judul),
                'isi' => $request->isi,
                'gambar' => $gambarPath ?? null,
                'is_published' => $request->is_published,
                'published_at' => $request->published_at ?? now(),
                'tanggal_selesai' => $request->tanggal_selesai
            ]);
            
            Log::info('Pengumuman berhasil disimpan', ['data' => $pengumuman]);
            return ResponseService::success($pengumuman, 'Pengumuman berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan pengumuman: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan pengumuman');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail pengumuman', ['id' => $id]);
            $pengumuman = Pengumuman::find($id);
            
            if (!$pengumuman) {
                Log::warning('Pengumuman tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengumuman tidak ditemukan');
            }
            
            Log::info('Detail pengumuman berhasil diambil', ['data' => $pengumuman]);
            return ResponseService::success($pengumuman, 'Detail pengumuman berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail pengumuman: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail pengumuman');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate pengumuman', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'sometimes|required|string|max:255',
                'isi' => 'sometimes|required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_published' => 'sometimes|required|boolean',
                'published_at' => 'nullable|date',
                'tanggal_selesai' => 'sometimes|required|date|after_or_equal:published_at'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $pengumuman = Pengumuman::find($id);
            
            if (!$pengumuman) {
                Log::warning('Pengumuman tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengumuman tidak ditemukan');
            }

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama
                if ($pengumuman->gambar) {
                    Storage::disk('public')->delete($pengumuman->gambar);
                }
                
                // Upload gambar baru
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('pengumuman', 'public');
                $pengumuman->gambar = $gambarPath;
            }

            if ($request->has('judul')) {
                $pengumuman->slug = \Str::slug($request->judul);
            }

            $pengumuman->update($request->except(['gambar', 'slug']));
            
            Log::info('Pengumuman berhasil diupdate', ['data' => $pengumuman]);
            return ResponseService::success($pengumuman, 'Pengumuman berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate pengumuman: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate pengumuman');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus pengumuman', ['id' => $id]);
            $pengumuman = Pengumuman::find($id);
            
            if (!$pengumuman) {
                Log::warning('Pengumuman tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengumuman tidak ditemukan');
            }

            // Hapus gambar
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            
            $pengumuman->delete();
            
            Log::info('Pengumuman berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Pengumuman berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus pengumuman: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus pengumuman');
        }
    }

    public function aktif()
    {
        try {
            Log::info('Mencoba mengambil pengumuman aktif');
            $pengumuman = Pengumuman::where('is_published', true)
                ->where('published_at', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->orderBy('published_at', 'desc')
                ->get();
            
            Log::info('Data pengumuman aktif berhasil diambil', ['count' => $pengumuman->count()]);
            return ResponseService::success($pengumuman, 'Data pengumuman aktif berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil pengumuman aktif: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil pengumuman aktif');
        }
    }
} 
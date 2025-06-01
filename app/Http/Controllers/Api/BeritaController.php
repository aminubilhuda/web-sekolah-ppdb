<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data berita');
            $berita = Berita::with('kategori')
                ->where('is_published', true)
                ->where('published_at', '<=', now())
                ->orderBy('published_at', 'desc')
                ->get();
            
            Log::info('Data berita berhasil diambil', ['count' => $berita->count()]);
            return response()->json($berita);
        } catch (\Exception $e) {
            Log::error('Error mengambil data berita: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan berita baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'konten' => 'required|string',
                'kategori_id' => 'required|exists:kategori,id',
                'is_published' => 'required|boolean',
                'published_at' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('berita', 'public');
            }

            $berita = Berita::create([
                'judul' => $request->judul,
                'slug' => \Str::slug($request->judul),
                'konten' => $request->konten,
                'kategori_id' => $request->kategori_id,
                'is_published' => $request->is_published,
                'published_at' => $request->published_at ?? now(),
                'image' => $imagePath ?? null
            ]);
            
            Log::info('Berita berhasil disimpan', ['data' => $berita]);
            return response()->json($berita, 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan berita: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail berita', ['id' => $id]);
            $berita = Berita::with('kategori')->find($id);
            
            if (!$berita) {
                Log::warning('Berita tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            Log::info('Detail berita berhasil diambil', ['data' => $berita]);
            return response()->json($berita);
        } catch (\Exception $e) {
            Log::error('Error mengambil detail berita: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate berita', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'sometimes|required|string|max:255',
                'konten' => 'sometimes|required|string',
                'kategori_id' => 'sometimes|required|exists:kategori,id',
                'is_published' => 'sometimes|required|boolean',
                'published_at' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $berita = Berita::find($id);
            
            if (!$berita) {
                Log::warning('Berita tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($berita->image) {
                    Storage::disk('public')->delete($berita->image);
                }
                
                // Upload gambar baru
                $image = $request->file('image');
                $imagePath = $image->store('berita', 'public');
                $berita->image = $imagePath;
            }

            if ($request->has('judul')) {
                $berita->slug = \Str::slug($request->judul);
            }

            $berita->update($request->except(['image', 'slug']));
            
            Log::info('Berita berhasil diupdate', ['data' => $berita]);
            return response()->json($berita);
        } catch (\Exception $e) {
            Log::error('Error mengupdate berita: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus berita', ['id' => $id]);
            $berita = Berita::find($id);
            
            if (!$berita) {
                Log::warning('Berita tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus gambar
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            
            $berita->delete();
            
            Log::info('Berita berhasil dihapus', ['id' => $id]);
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error menghapus berita: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
} 
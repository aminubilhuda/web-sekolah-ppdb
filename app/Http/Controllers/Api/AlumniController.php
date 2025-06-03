<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlumniController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data alumni');
            $alumni = Alumni::with('jurusan')
                ->active()
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data alumni berhasil diambil', ['count' => $alumni->count()]);
            return ResponseService::success($alumni, 'Data alumni berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data alumni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data alumni');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan alumni baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'jurusan_id' => 'required|exists:jurusan,id',
                'tahun_lulus' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required|in:bekerja,kuliah,wirausaha',
                'perusahaan' => 'required_if:status,bekerja|nullable|string|max:255',
                'jabatan' => 'required_if:status,bekerja|nullable|string|max:255',
                'universitas' => 'required_if:status,kuliah|nullable|string|max:255',
                'jurusan_kuliah' => 'required_if:status,kuliah|nullable|string|max:255',
                'jenjang' => 'required_if:status,kuliah|nullable|string|max:50',
                'usaha' => 'required_if:status,wirausaha|nullable|string|max:255',
                'testimoni' => 'nullable|string',
                'is_active' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoPath = $foto->store('alumni', 'public');
            }

            $alumni = Alumni::create([
                'nama' => $request->nama,
                'jurusan_id' => $request->jurusan_id,
                'tahun_lulus' => $request->tahun_lulus,
                'foto' => $fotoPath ?? null,
                'status' => $request->status,
                'perusahaan' => $request->perusahaan,
                'jabatan' => $request->jabatan,
                'universitas' => $request->universitas,
                'jurusan_kuliah' => $request->jurusan_kuliah,
                'jenjang' => $request->jenjang,
                'usaha' => $request->usaha,
                'testimoni' => $request->testimoni,
                'is_active' => $request->is_active
            ]);
            
            Log::info('Alumni berhasil disimpan', ['data' => $alumni]);
            return ResponseService::success($alumni, 'Alumni berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan alumni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan alumni');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail alumni', ['id' => $id]);
            $alumni = Alumni::with('jurusan')->find($id);
            
            if (!$alumni) {
                Log::warning('Alumni tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Alumni tidak ditemukan');
            }
            
            Log::info('Detail alumni berhasil diambil', ['data' => $alumni]);
            return ResponseService::success($alumni, 'Detail alumni berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail alumni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail alumni');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate alumni', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama' => 'sometimes|required|string|max:255',
                'jurusan_id' => 'sometimes|required|exists:jurusan,id',
                'tahun_lulus' => 'sometimes|required|integer|min:2000|max:' . (date('Y') + 1),
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'sometimes|required|in:bekerja,kuliah,wirausaha',
                'perusahaan' => 'required_if:status,bekerja|nullable|string|max:255',
                'jabatan' => 'required_if:status,bekerja|nullable|string|max:255',
                'universitas' => 'required_if:status,kuliah|nullable|string|max:255',
                'jurusan_kuliah' => 'required_if:status,kuliah|nullable|string|max:255',
                'jenjang' => 'required_if:status,kuliah|nullable|string|max:50',
                'usaha' => 'required_if:status,wirausaha|nullable|string|max:255',
                'testimoni' => 'nullable|string',
                'is_active' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $alumni = Alumni::find($id);
            
            if (!$alumni) {
                Log::warning('Alumni tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Alumni tidak ditemukan');
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($alumni->foto) {
                    Storage::disk('public')->delete($alumni->foto);
                }
                
                // Upload foto baru
                $foto = $request->file('foto');
                $fotoPath = $foto->store('alumni', 'public');
                $alumni->foto = $fotoPath;
            }

            $alumni->update($request->except('foto'));
            
            Log::info('Alumni berhasil diupdate', ['data' => $alumni]);
            return ResponseService::success($alumni, 'Alumni berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate alumni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate alumni');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus alumni', ['id' => $id]);
            $alumni = Alumni::find($id);
            
            if (!$alumni) {
                Log::warning('Alumni tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Alumni tidak ditemukan');
            }

            // Hapus foto
            if ($alumni->foto) {
                Storage::disk('public')->delete($alumni->foto);
            }
            
            $alumni->delete();
            
            Log::info('Alumni berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Alumni berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus alumni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus alumni');
        }
    }

    public function testimoni()
    {
        try {
            Log::info('Mencoba mengambil data testimoni alumni');
            $testimoni = Alumni::with('jurusan')
                ->active()
                ->whereNotNull('testimoni')
                ->orderBy('tahun_lulus', 'desc')
                ->get();
            
            Log::info('Data testimoni berhasil diambil', ['count' => $testimoni->count()]);
            return ResponseService::success($testimoni, 'Data testimoni berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data testimoni: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data testimoni');
        }
    }

    public function bekerja()
    {
        try {
            Log::info('Mencoba mengambil data alumni yang bekerja');
            $bekerja = Alumni::with('jurusan')
                ->active()
                ->bekerja()
                ->orderBy('tahun_lulus', 'desc')
                ->get();
            
            Log::info('Data alumni yang bekerja berhasil diambil', ['count' => $bekerja->count()]);
            return ResponseService::success($bekerja, 'Data alumni yang bekerja berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data alumni yang bekerja: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data alumni yang bekerja');
        }
    }

    public function kuliah()
    {
        try {
            Log::info('Mencoba mengambil data alumni yang kuliah');
            $kuliah = Alumni::with('jurusan')
                ->active()
                ->kuliah()
                ->orderBy('tahun_lulus', 'desc')
                ->get();
            
            Log::info('Data alumni yang kuliah berhasil diambil', ['count' => $kuliah->count()]);
            return ResponseService::success($kuliah, 'Data alumni yang kuliah berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data alumni yang kuliah: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data alumni yang kuliah');
        }
    }

    public function byJurusan($jurusan_id)
    {
        try {
            Log::info('Mencoba mengambil data alumni berdasarkan jurusan', ['jurusan_id' => $jurusan_id]);
            $alumni = Alumni::with('jurusan')
                ->active()
                ->where('jurusan_id', $jurusan_id)
                ->orderBy('tahun_lulus', 'desc')
                ->get();
            
            Log::info('Data alumni berdasarkan jurusan berhasil diambil', ['count' => $alumni->count()]);
            return ResponseService::success($alumni, 'Data alumni berdasarkan jurusan berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data alumni berdasarkan jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data alumni berdasarkan jurusan');
        }
    }

    public function byTahunLulus($tahun)
    {
        try {
            Log::info('Mencoba mengambil data alumni berdasarkan tahun lulus', ['tahun' => $tahun]);
            $alumni = Alumni::with('jurusan')
                ->active()
                ->where('tahun_lulus', $tahun)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data alumni berdasarkan tahun lulus berhasil diambil', ['count' => $alumni->count()]);
            return ResponseService::success($alumni, 'Data alumni berdasarkan tahun lulus berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data alumni berdasarkan tahun lulus: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data alumni berdasarkan tahun lulus');
        }
    }
} 
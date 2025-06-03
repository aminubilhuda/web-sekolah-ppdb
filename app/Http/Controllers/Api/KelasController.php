<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data kelas');
            $kelas = Kelas::with(['jurusan', 'waliKelas'])
                ->where('is_published', true)
                ->orderBy('nama_kelas', 'asc')
                ->get();
            
            Log::info('Data kelas berhasil diambil', ['count' => $kelas->count()]);
            return ResponseService::success($kelas, 'Data kelas berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data kelas');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan kelas baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_kelas' => 'required|string|max:255',
                'jurusan_id' => 'required|exists:jurusan,id',
                'wali_kelas_id' => 'nullable|exists:guru,id',
                'kapasitas' => 'required|integer|min:1',
                'tahun_ajaran' => 'required|string|max:9',
                'is_published' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $kelas = Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'slug' => \Str::slug($request->nama_kelas),
                'jurusan_id' => $request->jurusan_id,
                'wali_kelas_id' => $request->wali_kelas_id,
                'kapasitas' => $request->kapasitas,
                'tahun_ajaran' => $request->tahun_ajaran,
                'is_published' => $request->is_published
            ]);
            
            Log::info('Kelas berhasil disimpan', ['data' => $kelas]);
            return ResponseService::success($kelas, 'Kelas berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan kelas');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail kelas', ['id' => $id]);
            $kelas = Kelas::with(['jurusan', 'waliKelas'])->find($id);
            
            if (!$kelas) {
                Log::warning('Kelas tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Kelas tidak ditemukan');
            }
            
            Log::info('Detail kelas berhasil diambil', ['data' => $kelas]);
            return ResponseService::success($kelas, 'Detail kelas berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail kelas');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate kelas', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_kelas' => 'sometimes|required|string|max:255',
                'jurusan_id' => 'sometimes|required|exists:jurusan,id',
                'wali_kelas_id' => 'nullable|exists:guru,id',
                'kapasitas' => 'sometimes|required|integer|min:1',
                'tahun_ajaran' => 'sometimes|required|string|max:9',
                'is_published' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $kelas = Kelas::find($id);
            
            if (!$kelas) {
                Log::warning('Kelas tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Kelas tidak ditemukan');
            }

            if ($request->has('nama_kelas')) {
                $kelas->slug = \Str::slug($request->nama_kelas);
            }

            $kelas->update($request->except('slug'));
            
            Log::info('Kelas berhasil diupdate', ['data' => $kelas]);
            return ResponseService::success($kelas, 'Kelas berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate kelas');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus kelas', ['id' => $id]);
            $kelas = Kelas::find($id);
            
            if (!$kelas) {
                Log::warning('Kelas tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Kelas tidak ditemukan');
            }
            
            $kelas->delete();
            
            Log::info('Kelas berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Kelas berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus kelas');
        }
    }

    public function byJurusan($jurusanId)
    {
        try {
            Log::info('Mencoba mengambil data kelas berdasarkan jurusan', ['jurusan_id' => $jurusanId]);
            $kelas = Kelas::with(['jurusan', 'waliKelas'])
                ->where('jurusan_id', $jurusanId)
                ->where('is_published', true)
                ->orderBy('nama_kelas', 'asc')
                ->get();
            
            Log::info('Data kelas berhasil diambil', ['count' => $kelas->count()]);
            return ResponseService::success($kelas, 'Data kelas berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data kelas');
        }
    }

    public function byTahunAjaran($tahunAjaran)
    {
        try {
            Log::info('Mencoba mengambil data kelas berdasarkan tahun ajaran', ['tahun_ajaran' => $tahunAjaran]);
            $kelas = Kelas::with(['jurusan', 'waliKelas'])
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('is_published', true)
                ->orderBy('nama_kelas', 'asc')
                ->get();
            
            Log::info('Data kelas berhasil diambil', ['count' => $kelas->count()]);
            return ResponseService::success($kelas, 'Data kelas berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data kelas');
        }
    }
} 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PpdbController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data pendaftaran PPDB');
            $ppdb = Ppdb::orderBy('created_at', 'desc')->get();
            
            Log::info('Data pendaftaran PPDB berhasil diambil', ['count' => $ppdb->count()]);
            return ResponseService::success($ppdb, 'Data pendaftaran PPDB berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data pendaftaran PPDB');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan pendaftaran PPDB baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'required|string|max:255',
                'nisn' => 'required|string|max:255|unique:ppdb',
                'tempat_lahir' => 'required|string|max:255',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'agama' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'nama_ortu' => 'required|string|max:255',
                'no_hp' => 'required|string|max:255',
                'asal_sekolah' => 'required|string|max:255',
                'jurusan_pilihan' => 'required|string|max:255',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'ijazah' => 'required|file|mimes:pdf|max:2048',
                'kk' => 'required|file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $data = $request->all();
            
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('ppdb/foto', 'public');
            }
            
            if ($request->hasFile('ijazah')) {
                $data['ijazah'] = $request->file('ijazah')->store('ppdb/ijazah', 'public');
            }
            
            if ($request->hasFile('kk')) {
                $data['kk'] = $request->file('kk')->store('ppdb/kk', 'public');
            }

            $ppdb = Ppdb::create($data);
            
            Log::info('Pendaftaran PPDB berhasil disimpan', ['data' => $ppdb]);
            return ResponseService::success($ppdb, 'Pendaftaran PPDB berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan pendaftaran PPDB');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail pendaftaran PPDB', ['id' => $id]);
            $ppdb = Ppdb::find($id);
            
            if (!$ppdb) {
                Log::warning('Pendaftaran PPDB tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pendaftaran PPDB tidak ditemukan');
            }
            
            Log::info('Detail pendaftaran PPDB berhasil diambil', ['data' => $ppdb]);
            return ResponseService::success($ppdb, 'Detail pendaftaran PPDB berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail pendaftaran PPDB');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate pendaftaran PPDB', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nama_lengkap' => 'sometimes|required|string|max:255',
                'nisn' => 'sometimes|required|string|max:255|unique:ppdb,nisn,' . $id,
                'tempat_lahir' => 'sometimes|required|string|max:255',
                'tanggal_lahir' => 'sometimes|required|date',
                'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
                'agama' => 'sometimes|required|string|max:255',
                'alamat' => 'sometimes|required|string|max:255',
                'nama_ortu' => 'sometimes|required|string|max:255',
                'no_hp' => 'sometimes|required|string|max:255',
                'asal_sekolah' => 'sometimes|required|string|max:255',
                'jurusan_pilihan' => 'sometimes|required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'ijazah' => 'nullable|file|mimes:pdf|max:2048',
                'kk' => 'nullable|file|mimes:pdf|max:2048',
                'status' => 'sometimes|required|in:menunggu,diterima,ditolak',
                'catatan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $ppdb = Ppdb::find($id);
            
            if (!$ppdb) {
                Log::warning('Pendaftaran PPDB tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pendaftaran PPDB tidak ditemukan');
            }

            $data = $request->except(['foto', 'ijazah', 'kk']);

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($ppdb->foto) {
                    Storage::disk('public')->delete($ppdb->foto);
                }
                $data['foto'] = $request->file('foto')->store('ppdb/foto', 'public');
            }
            
            if ($request->hasFile('ijazah')) {
                // Hapus ijazah lama
                if ($ppdb->ijazah) {
                    Storage::disk('public')->delete($ppdb->ijazah);
                }
                $data['ijazah'] = $request->file('ijazah')->store('ppdb/ijazah', 'public');
            }
            
            if ($request->hasFile('kk')) {
                // Hapus kk lama
                if ($ppdb->kk) {
                    Storage::disk('public')->delete($ppdb->kk);
                }
                $data['kk'] = $request->file('kk')->store('ppdb/kk', 'public');
            }

            $ppdb->update($data);
            
            Log::info('Pendaftaran PPDB berhasil diupdate', ['data' => $ppdb]);
            return ResponseService::success($ppdb, 'Pendaftaran PPDB berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate pendaftaran PPDB');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus pendaftaran PPDB', ['id' => $id]);
            $ppdb = Ppdb::find($id);
            
            if (!$ppdb) {
                Log::warning('Pendaftaran PPDB tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pendaftaran PPDB tidak ditemukan');
            }

            // Hapus file
            if ($ppdb->foto) {
                Storage::disk('public')->delete($ppdb->foto);
            }
            if ($ppdb->ijazah) {
                Storage::disk('public')->delete($ppdb->ijazah);
            }
            if ($ppdb->kk) {
                Storage::disk('public')->delete($ppdb->kk);
            }
            
            $ppdb->delete();
            
            Log::info('Pendaftaran PPDB berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Pendaftaran PPDB berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus pendaftaran PPDB');
        }
    }

    public function checkStatus(Request $request)
    {
        try {
            Log::info('Mencoba mengecek status pendaftaran PPDB', ['nisn' => $request->nisn]);
            
            $validator = Validator::make($request->all(), [
                'nisn' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $ppdb = Ppdb::where('nisn', $request->nisn)->first();

            if (!$ppdb) {
                Log::warning('Pendaftaran PPDB tidak ditemukan', ['nisn' => $request->nisn]);
                return ResponseService::notFound('Pendaftaran PPDB tidak ditemukan');
            }

            Log::info('Status pendaftaran PPDB berhasil diambil', ['status' => $ppdb->status]);
            return ResponseService::success(['status' => $ppdb->status], 'Status pendaftaran PPDB berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengecek status pendaftaran PPDB: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengecek status pendaftaran PPDB');
        }
    }

    public function byStatus($status)
    {
        try {
            Log::info('Mencoba mengambil data pendaftaran PPDB berdasarkan status', ['status' => $status]);
            
            $validator = Validator::make(['status' => $status], [
                'status' => 'required|in:menunggu,diterima,ditolak',
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $ppdb = Ppdb::where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
            
            Log::info('Data pendaftaran PPDB berdasarkan status berhasil diambil', ['count' => $ppdb->count()]);
            return ResponseService::success($ppdb, 'Data pendaftaran PPDB berdasarkan status berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data pendaftaran PPDB berdasarkan status: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data pendaftaran PPDB berdasarkan status');
        }
    }
} 
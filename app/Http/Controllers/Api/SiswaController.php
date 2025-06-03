<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data siswa');
            $siswa = Siswa::with(['jurusan', 'kelas'])
                ->where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data siswa berhasil diambil', ['count' => $siswa->count()]);
            return ResponseService::success($siswa, 'Data siswa berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data siswa: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data siswa');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan siswa baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nis' => 'required|string|max:20|unique:siswa',
                'nisn' => 'required|string|max:20|unique:siswa',
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|string|max:20',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email|max:255|unique:siswa',
                'jurusan_id' => 'required|exists:jurusan,id',
                'kelas_id' => 'required|exists:kelas,id',
                'tahun_masuk' => 'required|integer|min:2000|max:' . (date('Y') + 1),
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoPath = $foto->store('siswa', 'public');
            }

            $siswa = Siswa::create([
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'jurusan_id' => $request->jurusan_id,
                'kelas_id' => $request->kelas_id,
                'tahun_masuk' => $request->tahun_masuk,
                'foto' => $fotoPath ?? null,
                'status' => $request->status
            ]);
            
            Log::info('Siswa berhasil disimpan', ['data' => $siswa]);
            return ResponseService::success($siswa, 'Siswa berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan siswa: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan siswa');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail siswa', ['id' => $id]);
            $siswa = Siswa::with(['jurusan', 'kelas'])->find($id);
            
            if (!$siswa) {
                Log::warning('Siswa tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Siswa tidak ditemukan');
            }
            
            Log::info('Detail siswa berhasil diambil', ['data' => $siswa]);
            return ResponseService::success($siswa, 'Detail siswa berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail siswa: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail siswa');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate siswa', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nis' => 'sometimes|required|string|max:20|unique:siswa,nis,' . $id,
                'nisn' => 'sometimes|required|string|max:20|unique:siswa,nisn,' . $id,
                'nama' => 'sometimes|required|string|max:255',
                'jenis_kelamin' => 'sometimes|required|in:L,P',
                'tempat_lahir' => 'sometimes|required|string|max:100',
                'tanggal_lahir' => 'sometimes|required|date',
                'agama' => 'sometimes|required|string|max:20',
                'alamat' => 'sometimes|required|string',
                'no_hp' => 'sometimes|required|string|max:15',
                'email' => 'sometimes|required|email|max:255|unique:siswa,email,' . $id,
                'jurusan_id' => 'sometimes|required|exists:jurusan,id',
                'kelas_id' => 'sometimes|required|exists:kelas,id',
                'tahun_masuk' => 'sometimes|required|integer|min:2000|max:' . (date('Y') + 1),
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $siswa = Siswa::find($id);
            
            if (!$siswa) {
                Log::warning('Siswa tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Siswa tidak ditemukan');
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($siswa->foto) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                
                // Upload foto baru
                $foto = $request->file('foto');
                $fotoPath = $foto->store('siswa', 'public');
                $siswa->foto = $fotoPath;
            }

            $siswa->update($request->except('foto'));
            
            Log::info('Siswa berhasil diupdate', ['data' => $siswa]);
            return ResponseService::success($siswa, 'Siswa berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate siswa: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate siswa');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus siswa', ['id' => $id]);
            $siswa = Siswa::find($id);
            
            if (!$siswa) {
                Log::warning('Siswa tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Siswa tidak ditemukan');
            }

            // Hapus foto
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            
            $siswa->delete();
            
            Log::info('Siswa berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Siswa berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus siswa: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus siswa');
        }
    }

    public function byJurusan($jurusan_id)
    {
        try {
            Log::info('Mencoba mengambil data siswa berdasarkan jurusan', ['jurusan_id' => $jurusan_id]);
            $siswa = Siswa::with(['jurusan', 'kelas'])
                ->where('jurusan_id', $jurusan_id)
                ->where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data siswa berdasarkan jurusan berhasil diambil', ['count' => $siswa->count()]);
            return ResponseService::success($siswa, 'Data siswa berdasarkan jurusan berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data siswa berdasarkan jurusan: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data siswa berdasarkan jurusan');
        }
    }

    public function byKelas($kelas_id)
    {
        try {
            Log::info('Mencoba mengambil data siswa berdasarkan kelas', ['kelas_id' => $kelas_id]);
            $siswa = Siswa::with(['jurusan', 'kelas'])
                ->where('kelas_id', $kelas_id)
                ->where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data siswa berdasarkan kelas berhasil diambil', ['count' => $siswa->count()]);
            return ResponseService::success($siswa, 'Data siswa berdasarkan kelas berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data siswa berdasarkan kelas: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data siswa berdasarkan kelas');
        }
    }

    public function byTahunMasuk($tahun)
    {
        try {
            Log::info('Mencoba mengambil data siswa berdasarkan tahun masuk', ['tahun' => $tahun]);
            $siswa = Siswa::with(['jurusan', 'kelas'])
                ->where('tahun_masuk', $tahun)
                ->where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data siswa berdasarkan tahun masuk berhasil diambil', ['count' => $siswa->count()]);
            return ResponseService::success($siswa, 'Data siswa berdasarkan tahun masuk berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data siswa berdasarkan tahun masuk: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data siswa berdasarkan tahun masuk');
        }
    }
} 
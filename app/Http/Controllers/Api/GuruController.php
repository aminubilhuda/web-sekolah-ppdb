<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data guru');
            $guru = Guru::where('status', true)
                ->orderBy('nama', 'asc')
                ->get();
            
            Log::info('Data guru berhasil diambil', ['count' => $guru->count()]);
            return ResponseService::success($guru, 'Data guru berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data guru: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data guru');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan guru baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nip' => 'required|string|max:20|unique:guru',
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required|string|max:100',
                'tanggal_lahir' => 'required|date',
                'agama' => 'required|string|max:20',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email|max:255|unique:guru',
                'pendidikan' => 'required|string|max:100',
                'jurusan' => 'required|string|max:100',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoPath = $foto->store('guru', 'public');
            }

            $guru = Guru::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'pendidikan' => $request->pendidikan,
                'jurusan' => $request->jurusan,
                'foto' => $fotoPath ?? null,
                'status' => $request->status
            ]);
            
            Log::info('Guru berhasil disimpan', ['data' => $guru]);
            return ResponseService::success($guru, 'Guru berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan guru: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan guru');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail guru', ['id' => $id]);
            $guru = Guru::find($id);
            
            if (!$guru) {
                Log::warning('Guru tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Guru tidak ditemukan');
            }
            
            Log::info('Detail guru berhasil diambil', ['data' => $guru]);
            return ResponseService::success($guru, 'Detail guru berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail guru: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail guru');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate guru', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'nip' => 'sometimes|required|string|max:20|unique:guru,nip,' . $id,
                'nama' => 'sometimes|required|string|max:255',
                'jenis_kelamin' => 'sometimes|required|in:L,P',
                'tempat_lahir' => 'sometimes|required|string|max:100',
                'tanggal_lahir' => 'sometimes|required|date',
                'agama' => 'sometimes|required|string|max:20',
                'alamat' => 'sometimes|required|string',
                'no_hp' => 'sometimes|required|string|max:15',
                'email' => 'sometimes|required|email|max:255|unique:guru,email,' . $id,
                'pendidikan' => 'sometimes|required|string|max:100',
                'jurusan' => 'sometimes|required|string|max:100',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'status' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $guru = Guru::find($id);
            
            if (!$guru) {
                Log::warning('Guru tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Guru tidak ditemukan');
            }

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($guru->foto) {
                    Storage::disk('public')->delete($guru->foto);
                }
                
                // Upload foto baru
                $foto = $request->file('foto');
                $fotoPath = $foto->store('guru', 'public');
                $guru->foto = $fotoPath;
            }

            $guru->update($request->except('foto'));
            
            Log::info('Guru berhasil diupdate', ['data' => $guru]);
            return ResponseService::success($guru, 'Guru berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate guru: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate guru');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus guru', ['id' => $id]);
            $guru = Guru::find($id);
            
            if (!$guru) {
                Log::warning('Guru tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Guru tidak ditemukan');
            }

            // Hapus foto
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            
            $guru->delete();
            
            Log::info('Guru berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Guru berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus guru: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus guru');
        }
    }
} 
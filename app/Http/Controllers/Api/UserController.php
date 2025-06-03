<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data pengguna');
            $users = User::orderBy('name')->get();
            
            Log::info('Data pengguna berhasil diambil', ['count' => $users->count()]);
            return ResponseService::success($users, 'Data pengguna berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data pengguna');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan pengguna baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,operator',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->is_active ?? true
            ]);
            
            Log::info('Pengguna berhasil disimpan', ['data' => $user]);
            return ResponseService::success($user, 'Pengguna berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan pengguna');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail pengguna', ['id' => $id]);
            $user = User::find($id);
            
            if (!$user) {
                Log::warning('Pengguna tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengguna tidak ditemukan');
            }
            
            Log::info('Detail pengguna berhasil diambil', ['data' => $user]);
            return ResponseService::success($user, 'Detail pengguna berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail pengguna');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate pengguna', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|required|string|min:8|confirmed',
                'role' => 'sometimes|required|in:admin,operator',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $user = User::find($id);
            
            if (!$user) {
                Log::warning('Pengguna tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengguna tidak ditemukan');
            }

            $data = $request->except('password');
            
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            
            Log::info('Pengguna berhasil diupdate', ['data' => $user]);
            return ResponseService::success($user, 'Pengguna berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate pengguna');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus pengguna', ['id' => $id]);
            $user = User::find($id);
            
            if (!$user) {
                Log::warning('Pengguna tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Pengguna tidak ditemukan');
            }
            
            $user->delete();
            
            Log::info('Pengguna berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus pengguna');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            Log::info('Mencoba mengupdate profil pengguna', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . auth()->id(),
                'current_password' => 'required_with:password|string',
                'password' => 'sometimes|required|string|min:8|confirmed'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $user = auth()->user();
            $data = $request->except(['current_password', 'password']);

            if ($request->has('password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return ResponseService::validationError(['current_password' => ['Password saat ini tidak sesuai']]);
                }
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            
            Log::info('Profil pengguna berhasil diupdate', ['data' => $user]);
            return ResponseService::success($user, 'Profil pengguna berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate profil pengguna: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate profil pengguna');
        }
    }
} 
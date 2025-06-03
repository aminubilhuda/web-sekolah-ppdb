<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    public function index()
    {
        try {
            Log::info('Mencoba mengambil data agenda');
            $agenda = Agenda::where('status', true)
                ->orderBy('tanggal_mulai', 'asc')
                ->get();
            
            Log::info('Data agenda berhasil diambil', ['count' => $agenda->count()]);
            return ResponseService::success($agenda, 'Data agenda berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil data agenda: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil data agenda');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Mencoba menyimpan agenda baru', ['data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'lokasi' => 'nullable|string|max:255',
                'status' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $agenda = Agenda::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'status' => $request->status
            ]);
            
            Log::info('Agenda berhasil disimpan', ['data' => $agenda]);
            return ResponseService::success($agenda, 'Agenda berhasil disimpan', 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan agenda: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menyimpan agenda');
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail agenda', ['id' => $id]);
            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Agenda tidak ditemukan');
            }
            
            Log::info('Detail agenda berhasil diambil', ['data' => $agenda]);
            return ResponseService::success($agenda, 'Detail agenda berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error mengambil detail agenda: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengambil detail agenda');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate agenda', ['id' => $id, 'data' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'judul' => 'sometimes|required|string|max:255',
                'deskripsi' => 'sometimes|required|string',
                'tanggal_mulai' => 'sometimes|required|date',
                'tanggal_selesai' => 'sometimes|required|date|after_or_equal:tanggal_mulai',
                'lokasi' => 'nullable|string|max:255',
                'status' => 'sometimes|required|boolean'
            ]);

            if ($validator->fails()) {
                Log::warning('Validasi gagal', ['errors' => $validator->errors()]);
                return ResponseService::validationError($validator->errors());
            }

            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Agenda tidak ditemukan');
            }

            $agenda->update($request->all());
            
            Log::info('Agenda berhasil diupdate', ['data' => $agenda]);
            return ResponseService::success($agenda, 'Agenda berhasil diupdate');
        } catch (\Exception $e) {
            Log::error('Error mengupdate agenda: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat mengupdate agenda');
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus agenda', ['id' => $id]);
            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return ResponseService::notFound('Agenda tidak ditemukan');
            }
            
            $agenda->delete();
            
            Log::info('Agenda berhasil dihapus', ['id' => $id]);
            return ResponseService::success(null, 'Agenda berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error menghapus agenda: ' . $e->getMessage());
            return ResponseService::serverError('Terjadi kesalahan saat menghapus agenda');
        }
    }
} 
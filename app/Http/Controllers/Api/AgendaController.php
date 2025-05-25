<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
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
            return response()->json($agenda);
        } catch (\Exception $e) {
            Log::error('Error mengambil data agenda: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
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
                return response()->json(['errors' => $validator->errors()], 422);
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
            return response()->json($agenda, 201);
        } catch (\Exception $e) {
            Log::error('Error menyimpan agenda: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function show($id)
    {
        try {
            Log::info('Mencoba mengambil detail agenda', ['id' => $id]);
            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            Log::info('Detail agenda berhasil diambil', ['data' => $agenda]);
            return response()->json($agenda);
        } catch (\Exception $e) {
            Log::error('Error mengambil detail agenda: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
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
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $agenda->update($request->all());
            
            Log::info('Agenda berhasil diupdate', ['data' => $agenda]);
            return response()->json($agenda);
        } catch (\Exception $e) {
            Log::error('Error mengupdate agenda: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('Mencoba menghapus agenda', ['id' => $id]);
            $agenda = Agenda::find($id);
            
            if (!$agenda) {
                Log::warning('Agenda tidak ditemukan', ['id' => $id]);
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            
            $agenda->delete();
            
            Log::info('Agenda berhasil dihapus', ['id' => $id]);
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error menghapus agenda: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
} 
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nama_ortu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'jurusan_pilihan' => 'required|string|max:255',
            'foto' => 'required|image|max:2048',
            'ijazah' => 'required|file|max:2048',
            'kk' => 'required|file|max:2048',
        ]);

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

        return response()->json([
            'message' => 'Pendaftaran berhasil',
            'data' => $ppdb
        ], 201);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string|max:255',
        ]);

        $ppdb = Ppdb::where('nisn', $request->nisn)->first();

        if (!$ppdb) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => $ppdb->status
        ]);
    }
} 
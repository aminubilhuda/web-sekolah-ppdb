<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('jurusan')->latest()->paginate(10);
        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        return view('siswa.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswa',
            'nisn' => 'nullable|string|max:20|unique:siswa',
            'nik' => 'nullable|string|size:16|unique:siswa',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kelas' => 'required|string|max:20',
            'jurusan' => 'required|string|max:50',
            // Data Orang Tua
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|size:16',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|size:16',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            // Data Wali
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|string|size:16',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'hubungan_wali' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('siswa/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        Siswa::create($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('jurusan');
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $jurusans = Jurusan::all();
        return view('siswa.edit', compact('siswa', 'jurusans'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nisn' => 'nullable|string|max:20|unique:siswa,nisn,' . $siswa->id,
            'nik' => 'nullable|string|size:16|unique:siswa,nik,' . $siswa->id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kelas' => 'required|string|max:20',
            'jurusan' => 'required|string|max:50',
            // Data Orang Tua
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ayah' => 'nullable|string|size:16',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'no_hp_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|size:16',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_hp_ibu' => 'nullable|string|max:20',
            // Data Wali
            'nama_wali' => 'nullable|string|max:255',
            'nik_wali' => 'nullable|string|size:16',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'hubungan_wali' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            
            // Upload foto baru
            $foto = $request->file('foto');
            $fotoPath = $foto->store('siswa/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        // Hapus foto
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
} 
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\Jurusan;
use App\Models\PPDBInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PPDBController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        $ppdbInfo = PPDBInfo::first();
        return view('web.ppdb.index', compact('jurusans', 'ppdbInfo'));
    }

    public function form()
    {
        $jurusans = Jurusan::all();
        return view('web.ppdb.form', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:ppdb',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:20',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:4',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'no_hp_ayah' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'no_hp_ibu' => 'required|string|max:20',
            'alamat_ortu' => 'required|string',
            'jurusan_pilihan' => 'required|exists:jurusan,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah' => 'nullable|file|mimes:pdf|max:2048',
            'kk' => 'nullable|file|mimes:pdf|max:2048'
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('ppdb/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        // Upload ijazah jika ada
        if ($request->hasFile('ijazah')) {
            $ijazah = $request->file('ijazah');
            $ijazahPath = $ijazah->store('ppdb/ijazah', 'public');
            $validated['ijazah'] = $ijazahPath;
        }

        // Upload KK jika ada
        if ($request->hasFile('kk')) {
            $kk = $request->file('kk');
            $kkPath = $kk->store('ppdb/kk', 'public');
            $validated['kk'] = $kkPath;
        }

        // Generate nomor pendaftaran
        $validated['nomor_pendaftaran'] = 'PPDB-' . date('Y') . '-' . str_pad(Ppdb::count() + 1, 4, '0', STR_PAD_LEFT);

        Ppdb::create($validated);

        return redirect()->route('web.ppdb.success')->with('success', 'Pendaftaran berhasil! Silahkan cek email Anda untuk informasi selanjutnya.');
    }

    public function success()
    {
        return view('web.ppdb.success');
    }

    public function status()
    {
        return view('web.ppdb.status');
    }

    public function check(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string'
        ]);

        $ppdb = Ppdb::with('jurusan')
            ->where('nomor_pendaftaran', $request->nomor_pendaftaran)
            ->first();

        if (!$ppdb) {
            return redirect()->route('web.ppdb.status')
                ->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }

        return view('web.ppdb.status', compact('ppdb'));
    }

    public function panduan()
    {
        return view('web.ppdb.panduan');
    }
} 
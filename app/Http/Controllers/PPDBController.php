<?php

namespace App\Http\Controllers;

use App\Models\PPDB;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;

class PPDBController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    public function index()
    {
        $jurusans = Jurusan::all();
        return view('ppdb.index', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:ppdb',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:20',
            'alamat' => 'required|string',
            'asal_sekolah' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama_ortu' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'foto' => 'required|image|max:2048',
            'ijazah' => 'required|file|mimes:pdf|max:2048',
            'kk' => 'required|file|mimes:pdf|max:2048'
        ]);

        // Upload foto
        $foto = $request->file('foto');
        $fotoPath = $foto->store('ppdb/foto', 'public');
        $validated['foto'] = $fotoPath;

        // Upload ijazah
        $ijazah = $request->file('ijazah');
        $ijazahPath = $ijazah->store('ppdb/ijazah', 'public');
        $validated['ijazah'] = $ijazahPath;

        // Upload KK
        $kk = $request->file('kk');
        $kkPath = $kk->store('ppdb/kk', 'public');
        $validated['kk'] = $kkPath;

        // Generate nomor pendaftaran
        $validated['nomor_pendaftaran'] = 'PPDB-' . date('Y') . '-' . str_pad(PPDB::count() + 1, 4, '0', STR_PAD_LEFT);

        // Simpan data pendaftaran
        $ppdb = PPDB::create($validated);

        try {
            // Kirim notifikasi ke siswa
            $this->fonnteService->sendPPDBNotification([
                'nama' => $ppdb->nama,
                'nomor_pendaftaran' => $ppdb->nomor_pendaftaran,
                'jurusan' => $ppdb->jurusan->nama,
                'asal_sekolah' => $ppdb->asal_sekolah,
                'no_hp' => $ppdb->no_hp
            ]);

            // Kirim notifikasi ke admin
            $this->fonnteService->sendPPDBAdminNotification([
                'nama' => $ppdb->nama,
                'nisn' => $ppdb->nisn,
                'nomor_pendaftaran' => $ppdb->nomor_pendaftaran,
                'jurusan' => $ppdb->jurusan->nama,
                'asal_sekolah' => $ppdb->asal_sekolah,
                'no_hp' => $ppdb->no_hp,
                'foto' => $ppdb->foto,
                'ijazah' => $ppdb->ijazah,
                'kk' => $ppdb->kk
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi WhatsApp', [
                'error' => $e->getMessage(),
                'ppdb_id' => $ppdb->id
            ]);
        }

        return redirect()->route('ppdb.success')->with('success', 'Pendaftaran berhasil! Silahkan cek WhatsApp Anda untuk informasi selanjutnya.');
    }

    public function success()
    {
        return view('ppdb.success');
    }

    public function check(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string'
        ]);

        $ppdb = PPDB::where('nomor_pendaftaran', $request->nomor_pendaftaran)->first();

        if (!$ppdb) {
            return back()->with('error', 'Nomor pendaftaran tidak ditemukan.');
        }

        return view('ppdb.check', compact('ppdb'));
    }
} 
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Infaq;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Infaq::with('kelas');

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        } else {
            $query->whereYear('tanggal', now()->year);
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $query->where('kelas_id', $request->kelas);
        }

        // Data untuk tampilan
        $infaqs = $query->latest()->paginate(10);
        $kelas = Kelas::all();
        $tahun = range(now()->year - 2, now()->year);

        // Statistik
        $totalHariIni = Infaq::hariIni()->sum('jumlah_infaq');
        $totalBulanIni = Infaq::bulanIni()->sum('jumlah_infaq');
        $totalTahunIni = Infaq::tahunIni()->sum('jumlah_infaq');

        // Grafik per kelas
        $grafikKelas = Infaq::select('kelas_id', DB::raw('SUM(jumlah_infaq) as total'))
            ->whereYear('tanggal', $request->tahun ?? now()->year)
            ->whereMonth('tanggal', $request->bulan ?? now()->month)
            ->groupBy('kelas_id')
            ->with('kelas')
            ->get();

        // Grafik bulanan
        $grafikBulanan = Infaq::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(jumlah_infaq) as total')
            )
            ->whereYear('tanggal', $request->tahun ?? now()->year)
            ->groupBy('bulan')
            ->get();

        return view('web.infaq.index', compact(
            'infaqs',
            'kelas',
            'tahun',
            'totalHariIni',
            'totalBulanIni',
            'totalTahunIni',
            'grafikKelas',
            'grafikBulanan'
        ));
    }
}

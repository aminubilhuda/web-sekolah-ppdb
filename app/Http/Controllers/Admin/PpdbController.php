<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PPDB;
use App\Exports\PpdbExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {
        $ppdbs = PPDB::latest()->get();
        return view('admin.ppdb.index', compact('ppdbs'));
    }

    public function export()
    {
        return Excel::download(new PpdbExport, 'data-ppdb-' . date('Y-m-d') . '.xlsx');
    }
} 
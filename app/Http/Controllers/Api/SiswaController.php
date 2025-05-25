<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::where('status', true)->get();
        return response()->json($siswa);
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }
} 
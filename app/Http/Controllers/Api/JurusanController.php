<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::where('status', true)->get();
        return response()->json($jurusan);
    }

    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }
} 
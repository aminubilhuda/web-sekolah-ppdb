<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::where('status', true)->get();
        return response()->json($guru);
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return response()->json($guru);
    }
} 
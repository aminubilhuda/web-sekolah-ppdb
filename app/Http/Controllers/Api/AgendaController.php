<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agenda = Agenda::where('status', true)
            ->orderBy('tanggal_mulai', 'asc')
            ->get();
        return response()->json($agenda);
    }

    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json($agenda);
    }
} 
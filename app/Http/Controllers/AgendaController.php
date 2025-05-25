<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::latest()->paginate(10);
        return view('agenda.index', compact('agendas'));
    }

    public function show(Agenda $agenda)
    {
        return view('agenda.show', compact('agenda'));
    }
} 
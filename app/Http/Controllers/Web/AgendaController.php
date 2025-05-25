<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::latest()->paginate(10);
        return view('web.agenda.index', compact('agendas'));
    }

    public function show(Agenda $agenda)
    {
        return view('web.agenda.show', compact('agenda'));
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::with('guru')->get();
        return view('ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->load('guru', 'siswa');
        return view('ekstrakurikuler.show', compact('ekstrakurikuler'));
    }
} 
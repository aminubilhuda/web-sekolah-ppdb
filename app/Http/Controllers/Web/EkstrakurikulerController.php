<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::all();
        return view('web.ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    public function show(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('web.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }
} 
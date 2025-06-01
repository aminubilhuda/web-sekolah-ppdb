<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // TODO: Implementasi untuk mengambil data FAQ dari database
        $faqs = []; // Ganti dengan data dari database
        return view('web.faq.index', compact('faqs'));
    }
} 
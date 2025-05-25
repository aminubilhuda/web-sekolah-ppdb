<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::where('status', true)->get();
        return response()->json($ekstrakurikuler);
    }

    public function show($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        return response()->json($ekstrakurikuler);
    }
} 
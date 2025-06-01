<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        try {
            $galeri = Galeri::where('is_active', true)
                ->latest()
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $galeri
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $galeri = Galeri::where('is_active', true)->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $galeri
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri tidak ditemukan'
            ], 404);
        }
    }

    public function foto()
    {
        try {
            $galeri = Galeri::where('is_active', true)
                ->where('tipe', 'foto')
                ->latest()
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $galeri
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function video()
    {
        try {
            $galeri = Galeri::where('is_active', true)
                ->where('tipe', 'video')
                ->latest()
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $galeri
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }
} 
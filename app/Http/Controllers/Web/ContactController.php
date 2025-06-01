<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $profil = CacheService::getProfilSekolah();
        return view('contact', compact('profil'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string'
        ]);

        // Simpan pesan ke database
        $kontak = Kontak::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'subjek' => $validated['subjek'],
            'pesan' => $validated['pesan'],
            'is_read' => false
        ]);

        // Kirim email notifikasi ke admin
        try {
            Mail::send('web.emails.contact', ['contact' => $kontak], function($message) use ($kontak) {
                $message->to('admin@sekolah.sch.id')
                        ->subject('Pesan Baru: ' . $kontak->subjek)
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });
        } catch (\Exception $e) {
            // Log error tapi tetap redirect dengan success karena data sudah tersimpan
            \Log::error('Error sending contact email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
} 
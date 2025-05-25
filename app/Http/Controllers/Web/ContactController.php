<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
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
        $contact = Contact::create($validated);

        // Kirim email notifikasi
        Mail::send('emails.contact', ['contact' => $contact], function($message) use ($contact) {
            $message->to('admin@sekolah.sch.id')
                    ->subject('Pesan Baru: ' . $contact->subjek);
        });

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
} 
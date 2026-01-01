<?php

namespace App\Http\Controllers;

use App\Models\WiadomoscKontaktowa;
use Illuminate\Http\Request;

class KontaktController extends Controller
{
    public function index()
    {
        return view('kontakt');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'temat' => 'required|string|max:255',
            'wiadomosc' => 'required|string|max:5000',
        ]);

        WiadomoscKontaktowa::create($validated);

        return redirect()->back()->with('success', 'Dziękujemy za wiadomość! Odpowiemy najszybciej jak to możliwe.');
    }
}

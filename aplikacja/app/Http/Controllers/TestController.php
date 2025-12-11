<?php

namespace App\Http\Controllers;

use App\Models\Rola;
use App\Models\Uzytkownik;
use App\Models\Kategoria;
use App\Models\Producent;
use App\Models\Sprzet;
use App\Models\StatusWypozyczenia;
use App\Models\Wypozyczenie;

class TestController extends Controller
{
    public function index()
    {
        $statystyki = [
            'role' => Rola::count(),
            'uzytkownicy' => Uzytkownik::count(),
            'kategorie' => Kategoria::count(),
            'producenci' => Producent::count(),
            'sprzet' => Sprzet::count(),
            'statusy' => StatusWypozyczenia::count(),
            'wypozyczenia' => Wypozyczenie::count(),
        ];

        $role = Rola::with('uzytkownicy')->get();
        $kategorie = Kategoria::whereNull('rodzic_id')->with('dzieci')->get();
        $sprzet = Sprzet::with(['kategoria', 'producent'])->get();
        $wypozyczenia = Wypozyczenie::with(['uzytkownik', 'pracownik', 'status', 'sprzety', 'platnosci'])->get();

        return view('test', compact('statystyki', 'role', 'kategorie', 'sprzet', 'wypozyczenia'));
    }
}

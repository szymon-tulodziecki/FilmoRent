<?php

namespace App\Http\Controllers;

use App\Models\Wypozyczenie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KontoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('logowanie')->with('error', 'Zaloguj się, aby zobaczyć swoje zamówienia.');
        }

        $aktywnyStatusy = ['Oczekuje na potwierdzenie', 'W realizacji', 'Wysyłka', 'Wydane'];
        $archiwumStatusy = ['Zwrócone', 'Zrealizowane', 'Zamknięte', 'Anulowane', 'Opóźnione'];

        $aktywne = Wypozyczenie::with(['status', 'sprzety'])
            ->where('uzytkownik_id', $user->id)
            ->whereHas('status', fn($q) => $q->whereIn('nazwa', $aktywnyStatusy))
            ->orderByDesc('utworzono_data')
            ->get();

        $archiwum = Wypozyczenie::with(['status', 'sprzety'])
            ->where('uzytkownik_id', $user->id)
            ->whereHas('status', fn($q) => $q->whereIn('nazwa', $archiwumStatusy))
            ->orderByDesc('utworzono_data')
            ->get();

        return view('konto', [
            'aktywne' => $aktywne,
            'archiwum' => $archiwum,
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('logowanie');
        }

        // Walidacja
        $validated = $request->validate([
            'imie' => 'required|string|max:100',
            'nazwisko' => 'required|string|max:100',
            'typ_klienta' => 'required|in:indywidualny,biznesowy',
            'pesel' => 'nullable|string|size:11',
            'nazwa_firmy' => 'nullable|string|max:255',
            'nip' => 'nullable|string|size:10',
            'regon' => 'nullable|string|max:14',
            'osoba_kontaktowa' => 'nullable|string|max:255',
            'stanowisko' => 'nullable|string|max:100',
            'telefon' => 'nullable|string|max:20',
        ]);

        // Zaktualizuj użytkownika
        $user->update($validated);

        return back()->with('success', 'Dane konta zaktualizowane pomyślnie!');
    }

    public function przedluz($id)
    {
        $wypozyczenie = Wypozyczenie::findOrFail($id);
        
        if ($wypozyczenie->uzytkownik_id !== Auth::id()) {
            abort(403);
        }

        $this->validateDates($wypozyczenie->data_odbioru, $wypozyczenie->data_zwrotu->addDays(7));
        
        $wypozyczenie->data_zwrotu = $wypozyczenie->data_zwrotu->addDays(7);
        $wypozyczenie->save();

        return back()->with('success', 'Wypożyczenie przedłużone do ' . $wypozyczenie->data_zwrotu->format('d.m.Y'));
    }

    public function anuluj($id)
    {
        $wypozyczenie = Wypozyczenie::findOrFail($id);
        
        if ($wypozyczenie->uzytkownik_id !== Auth::id()) {
            abort(403);
        }

        if ($wypozyczenie->status->klucz !== 'wRealizacji') {
            return back()->with('error', 'Możesz anulować tylko zamówienia w statusie "W realizacji"');
        }

        $anulowanyStatus = \App\Models\StatusWypozyczenia::where('klucz', 'anulowane')->first();
        $wypozyczenie->status_id = $anulowanyStatus->id;
        $wypozyczenie->save();

        return back()->with('success', 'Zamówienie zostało anulowane.');
    }

    private function validateDates($dataOd, $dataDo)
    {
        $konflikty = Wypozyczenie::where('id', '!=', null)
            ->whereIn('status_id', function($query) {
                $query->select('id')
                    ->from('statusy_wypozyczenia')
                    ->whereIn('nazwa', ['Potwierdzone', 'Wydane']);
            })
            ->where(function($query) use ($dataOd, $dataDo) {
                $query->whereBetween('data_odbioru', [$dataOd, $dataDo])
                    ->orWhereBetween('data_zwrotu', [$dataOd, $dataDo]);
            })
            ->exists();
        
        if ($konflikty) {
            throw new \Exception('Sprzęt jest już zarezerwowany w wybranych datach.');
        }
    }
}
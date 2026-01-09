<?php

namespace App\Http\Controllers;

use App\Models\Kategoria;
use App\Models\Producent;
use App\Models\Sprzet;
use App\Models\Wypozyczenie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SklepController extends Controller
{
    public function index(Request $request)
    {
        $query = Sprzet::with(['kategoria', 'producent'])
            ->where('status_sprzetu', 'dostepny');

        // Wyszukiwanie
        if ($request->filled('szukaj')) {
            $szukaj = $request->input('szukaj');
            $query->where(function ($q) use ($szukaj) {
                $q->where('nazwa', 'like', "%{$szukaj}%")
                  ->orWhere('opis', 'like', "%{$szukaj}%")
                  ->orWhereHas('kategoria', function ($kq) use ($szukaj) {
                      $kq->where('nazwa', 'like', "%{$szukaj}%")
                        ->orWhere('slowa_kluczowe', 'like', "%{$szukaj}%");
                  })
                  ->orWhereHas('producent', function ($pq) use ($szukaj) {
                      $pq->where('nazwa', 'like', "%{$szukaj}%");
                  });
            });
        }

        // Filtrowanie po kategorii
        if ($request->filled('kategoria')) {
            $query->where('kategoria_id', $request->input('kategoria'));
        }

        // Filtrowanie po producencie
        if ($request->filled('producent')) {
            $producenci_ids = $request->input('producent');
            if (is_array($producenci_ids) && !empty($producenci_ids)) {
                $query->whereIn('producent_id', $producenci_ids);
            }
        }

        // Filtrowanie po cenie
        if ($request->filled('cena_min') || $request->filled('cena_max')) {
            $cena_min = (float) $request->input('cena_min', 0);
            $cena_max = (float) $request->input('cena_max', 10000);
            $query->whereBetween('cena_doba', [$cena_min, $cena_max]);
        }

        // Sortowanie
        $sortowanie = $request->input('sortowanie', 'najnowsze');
        switch ($sortowanie) {
            case 'cena_rosnaco':
                $query->orderBy('cena_doba', 'asc');
                break;
            case 'cena_malejaco':
                $query->orderBy('cena_doba', 'desc');
                break;
            case 'nazwa':
                $query->orderBy('nazwa', 'asc');
                break;
            case 'najnowsze':
            default:
                $query->latest('utworzono_data');
                break;
        }

        $per_page = (int) $request->input('per_page', 9);
        $sprzety = $query->paginate($per_page);
        $kategorie = Kategoria::has('sprzety')->get();
        $producenci = Producent::withCount('sprzety')->get();

        return view('sklep', compact('sprzety', 'kategorie', 'producenci'));
    }

    public function getProducts(Request $request)
    {
        $query = Sprzet::with(['kategoria', 'producent'])
            ->where('status_sprzetu', 'dostepny');

        // Wyszukiwanie
        if ($request->filled('szukaj')) {
            $szukaj = $request->input('szukaj');
            $query->where(function ($q) use ($szukaj) {
                $q->where('nazwa', 'like', "%{$szukaj}%")
                  ->orWhere('opis', 'like', "%{$szukaj}%")
                  ->orWhereHas('kategoria', function ($kq) use ($szukaj) {
                      $kq->where('nazwa', 'like', "%{$szukaj}%")
                        ->orWhere('slowa_kluczowe', 'like', "%{$szukaj}%");
                  })
                  ->orWhereHas('producent', function ($pq) use ($szukaj) {
                      $pq->where('nazwa', 'like', "%{$szukaj}%");
                  });
            });
        }

        // Filtrowanie po kategorii
        if ($request->filled('kategoria')) {
            $query->where('kategoria_id', $request->input('kategoria'));
        }

        // Filtrowanie po producencie
        if ($request->filled('producent')) {
            $producenci_ids = $request->input('producent');
            if (is_array($producenci_ids) && !empty($producenci_ids)) {
                $query->whereIn('producent_id', $producenci_ids);
            }
        }

        // Filtrowanie po cenie
        if ($request->filled('cena_min') || $request->filled('cena_max')) {
            $cena_min = (float) $request->input('cena_min', 0);
            $cena_max = (float) $request->input('cena_max', 10000);
            $query->whereBetween('cena_doba', [$cena_min, $cena_max]);
        }

        // Sortowanie
        $sortowanie = $request->input('sortowanie', 'najnowsze');
        switch ($sortowanie) {
            case 'cena_rosnaco':
                $query->orderBy('cena_doba', 'asc');
                break;
            case 'cena_malejaco':
                $query->orderBy('cena_doba', 'desc');
                break;
            case 'nazwa':
                $query->orderBy('nazwa', 'asc');
                break;
            case 'najnowsze':
            default:
                $query->latest('utworzono_data');
                break;
        }

        $per_page = (int) $request->input('per_page', 9);
        $sprzety = $query->paginate($per_page);
        
        return response()->json([
            'html' => view('partials.produkty', compact('sprzety'))->render(),
            'total' => $sprzety->total(),
            'current_page' => $sprzety->currentPage(),
            'last_page' => $sprzety->lastPage(),
        ]);
    }

    public function show(Sprzet $sprzet)
    {
        $sprzet->load(['kategoria', 'producent']);
        
        // Pobierz podobne produkty z tej samej kategorii
        $podobne = Sprzet::with(['kategoria', 'producent'])
            ->where('kategoria_id', $sprzet->kategoria_id)
            ->where('id', '!=', $sprzet->id)
            ->where('status_sprzetu', 'dostepny')
            ->limit(4)
            ->get();
        
        return view('produkt', compact('sprzet', 'podobne'));
    }

    public function dodajDoKoszyka(Request $request)
    {
        // Obsługa dodawania zestawów (sprzet_ids) bez wymagania dat
        if ($request->filled('sprzet_ids')) {
            $sprzet_ids = explode(',', $request->input('sprzet_ids'));
            $koszyk = session()->get('koszyk', []);
            
            foreach ($sprzet_ids as $id) {
                $sprzet = Sprzet::find(trim($id));
                if ($sprzet) {
                    $koszyk[] = [
                        'sprzet_id' => $sprzet->id,
                        'nazwa' => $sprzet->nazwa,
                        'cena_doba' => $sprzet->cena_doba,
                        'data_od' => null,
                        'data_do' => null,
                        'dni' => 0,
                        'cena_calkowita' => 0,
                        'kaucja' => $sprzet->kaucja,
                        'producent' => $sprzet->producent->nazwa ?? null,
                        'kategoria' => $sprzet->kategoria->nazwa ?? null,
                        'zdjecie' => $sprzet->getZdjecieUrl(),
                    ];
                }
            }
            
            session()->put('koszyk', $koszyk);
            return redirect()->route('koszyk')->with('success', 'Dodano zestaw do koszyka! Teraz wybierz daty wypożyczenia.');
        }

        // Obsługa tradycyjnego dodawania pojedynczego sprzętu z datami
        $request->validate([
            'sprzet_id' => 'required|exists:sprzet,id',
            'data_od' => 'required|date|after_or_equal:today',
            'data_do' => 'required|date|after:data_od',
        ], [
            'data_od.after_or_equal' => 'Data rozpoczęcia nie może być w przeszłości',
            'data_do.after' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia',
        ]);

        $sprzet = Sprzet::findOrFail($request->sprzet_id);
        
        // Sprawdź dostępność w wybranych datach
        $dataOd = Carbon::parse($request->data_od);
        $dataDo = Carbon::parse($request->data_do);
        
        $konflikty = Wypozyczenie::whereHas('sprzety', function($query) use ($sprzet) {
                $query->where('sprzet_id', $sprzet->id);
            })
            ->whereIn('status_id', function($query) {
                $query->select('id')
                    ->from('statusy_wypozyczenia')
                    ->whereIn('klucz', ['oczekuje', 'wRealizacji', 'wysylka', 'wydane']);
            })
            ->where(function($query) use ($dataOd, $dataDo) {
                // Konflikt występuje gdy:
                // 1. Nowy okres rozpoczyna się w trakcie istniejącego wypożyczenia
                // 2. Nowy okres kończy się w trakcie istniejącego wypożyczenia  
                // 3. Nowy okres całkowicie obejmuje istniejące wypożyczenie
                $query->where(function($subQ) use ($dataOd, $dataDo) {
                    $subQ->where('data_odbioru', '<=', $dataOd)
                         ->where('data_zwrotu', '>=', $dataOd);
                })
                ->orWhere(function($subQ) use ($dataOd, $dataDo) {
                    $subQ->where('data_odbioru', '<=', $dataDo)
                         ->where('data_zwrotu', '>=', $dataDo);
                })
                ->orWhere(function($subQ) use ($dataOd, $dataDo) {
                    $subQ->where('data_odbioru', '>=', $dataOd)
                         ->where('data_zwrotu', '<=', $dataDo);
                });
            })
            ->exists();
        
        if ($konflikty) {
            return back()->with('error', 'Sprzęt jest już wypożyczony w wybranych datach. Wybierz inne daty.');
        }
        
        $dni = $dataOd->diffInDays($dataDo) + 1;
        $cenaCalkowita = $sprzet->cena_doba * $dni;
        
        // Dodaj do koszyka w sesji
        $koszyk = session()->get('koszyk', []);
        
        $koszyk[] = [
            'sprzet_id' => $sprzet->id,
            'nazwa' => $sprzet->nazwa,
            'cena_doba' => $sprzet->cena_doba,
            'data_od' => $request->data_od,
            'data_do' => $request->data_do,
            'dni' => $dni,
            'cena_calkowita' => $cenaCalkowita,
            'kaucja' => $sprzet->kaucja,
            'producent' => $sprzet->producent->nazwa ?? null,
            'kategoria' => $sprzet->kategoria->nazwa ?? null,
            'zdjecie' => $sprzet->getZdjecieUrl(),
        ];
        
        session()->put('koszyk', $koszyk);
        
        return back()->with('success', 'Dodano do koszyka! Wypożyczenie na ' . $dni . ' dni.');
    }

    public function usunZKoszyka($index)
    {
        $koszyk = session()->get('koszyk', []);
        
        if (isset($koszyk[$index])) {
            unset($koszyk[$index]);
            $koszyk = array_values($koszyk); // Reindeksuj
            session()->put('koszyk', $koszyk);
        }
        
        return back()->with('success', 'Usunięto z koszyka');
    }

    public function aktualizujDatyWKoszyku(Request $request)
    {
        $request->validate([
            'index' => 'required|integer',
            'data_od' => 'required|date',
            'data_do' => 'required|date|after:data_od',
        ]);

        $index = $request->input('index');
        $dataOd = Carbon::parse($request->input('data_od'));
        $dataDo = Carbon::parse($request->input('data_do'));
        
        $koszyk = session()->get('koszyk', []);
        
        if (!isset($koszyk[$index])) {
            return response()->json(['success' => false, 'message' => 'Pozycja nie istnieje w koszyku']);
        }

        $sprzet = Sprzet::find($koszyk[$index]['sprzet_id']);
        
        if (!$sprzet) {
            return response()->json(['success' => false, 'message' => 'Sprzęt nie istnieje']);
        }

        // Sprawdź dostępność na nowe daty
        $conflict = Wypozyczenie::whereHas('sprzety', function ($query) use ($sprzet) {
            $query->where('sprzet_id', $sprzet->id);
        })
        ->where(function ($q) use ($dataOd, $dataDo) {
            // Konflikt występuje gdy:
            // 1. Nowy okres rozpoczyna się w trakcie istniejącego wypożyczenia
            // 2. Nowy okres kończy się w trakcie istniejącego wypożyczenia  
            // 3. Nowy okres całkowicie obejmuje istniejące wypożyczenie
            $q->where(function($subQ) use ($dataOd, $dataDo) {
                $subQ->where('data_odbioru', '<=', $dataOd)
                     ->where('data_zwrotu', '>=', $dataOd);
            })
            ->orWhere(function($subQ) use ($dataOd, $dataDo) {
                $subQ->where('data_odbioru', '<=', $dataDo)
                     ->where('data_zwrotu', '>=', $dataDo);
            })
            ->orWhere(function($subQ) use ($dataOd, $dataDo) {
                $subQ->where('data_odbioru', '>=', $dataOd)
                     ->where('data_zwrotu', '<=', $dataDo);
            });
        })
        ->whereIn('status_id', function ($query) {
            $query->select('id')
                  ->from('statusy_wypozyczenia')
                  ->whereIn('klucz', ['oczekuje', 'wRealizacji', 'wysylka', 'wydane']);
        })
        ->exists();

        if ($conflict) {
            return response()->json(['success' => false, 'message' => 'Sprzęt jest już wypożyczony w wybranych datach']);
        }

        $dni = $dataOd->diffInDays($dataDo) + 1;
        $cenaCalkowita = $sprzet->cena_doba * $dni;

        // Aktualizuj pozycję w koszyku
        $koszyk[$index]['data_od'] = $request->input('data_od');
        $koszyk[$index]['data_do'] = $request->input('data_do');
        $koszyk[$index]['dni'] = $dni;
        $koszyk[$index]['cena_calkowita'] = $cenaCalkowita;
        
        session()->put('koszyk', $koszyk);
        
        return response()->json(['success' => true, 'message' => 'Daty zostały zaktualizowane']);
    }

    public function koszyk()
    {
        $koszyk = session()->get('koszyk', []);
        $suma = collect($koszyk)->sum('cena_calkowita');
        $kaucjaSuma = collect($koszyk)->sum('kaucja');

        return view('koszyk', [
            'koszyk' => $koszyk,
            'suma' => $suma,
            'kaucjaSuma' => $kaucjaSuma,
        ]);
    }

    public function zlozZamowienie(Request $request)
    {
        $koszyk = session()->get('koszyk', []);
        
        if (empty($koszyk)) {
            return back()->with('error', 'Koszyk jest pusty!');
        }

        if (!auth()->check()) {
            return redirect()->route('logowanie')->with('error', 'Musisz być zalogowany aby złożyć zamówienie.');
        }

        $user = auth()->user();

        // Sprawdź czy dane profilu są wypełnione
        if (empty($user->imie) || empty($user->nazwisko)) {
            return redirect()->route('konto')->with('error', 'Uzupełnij najpierw swoje imię i nazwisko w ustawieniach konta.');
        }

        // Sprawdź czy typ klienta jest wybrany
        if (empty($user->typ_klienta)) {
            return redirect()->route('konto')->with('error', 'Wybierz typ klienta (indywidualny lub biznesowy) w ustawieniach konta.');
        }

        // Walidacja danych w zależności od typu klienta
        if ($user->typ_klienta === 'indywidualny') {
            if (empty($user->pesel)) {
                return redirect()->route('konto')->with('error', 'Uzupełnij PESEL w ustawieniach konta (Dane osobowe).');
            }
        } elseif ($user->typ_klienta === 'biznesowy') {
            if (empty($user->nazwa_firmy) || empty($user->nip)) {
                return redirect()->route('konto')->with('error', 'Uzupełnij dane firmy (Nazwa firmy i NIP) w ustawieniach konta.');
            }
        }

        $suma = collect($koszyk)->sum('cena_calkowita');
        $kaucja = collect($koszyk)->sum('kaucja');
        
        // Utwórz zamówienie
        $wypozyczenie = new Wypozyczenie();
        $wypozyczenie->numer_zamowienia = 'ZAM-' . date('YmdHis') . '-' . $user->id;
        $wypozyczenie->uzytkownik_id = $user->id;
        $wypozyczenie->status_id = 1; // "oczekujące"
        $wypozyczenie->data_rezerwacji = now();
        $wypozyczenie->data_odbioru = Carbon::parse($koszyk[0]['data_od'] ?? now());
        $wypozyczenie->data_zwrotu = Carbon::parse($koszyk[0]['data_do'] ?? now()->addDays(1));
        $wypozyczenie->suma_calkowita = $suma;
        $wypozyczenie->utworzono_data = now();
        $wypozyczenie->save();
        
        // Dodaj produkty do zamówienia
        foreach ($koszyk as $item) {
            $wypozyczenie->sprzety()->attach($item['sprzet_id'], [
                'cena_netto_snapshot' => $item['cena_calkowita'],
                'rabat_procent' => 0,
            ]);
        }
        
        // Wyczyść koszyk
        session()->forget('koszyk');
        
        return redirect()->route('konto')
            ->with('success', 'Zamówienie nr ' . $wypozyczenie->numer_zamowienia . ' zostało złożone! Sprawdź status w swoim koncie.');
    }
}


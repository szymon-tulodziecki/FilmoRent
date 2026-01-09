
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SklepController;
use App\Http\Controllers\KontaktController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontoController;
use App\Models\Sprzet;
use App\Models\Kategoria;
use App\Models\Producent;
use App\Models\StatusWypozyczenia;
use App\Models\Rola;
use App\Models\Wypozyczenie;
use App\Models\Platnosc;
use App\Models\Adres;
use App\Models\Zalacznik;
use App\Models\Uzytkownik;

// Strona Główna - pobieramy sprzęt "na żywca" z Twoich modeli
Route::get('/', function () {
	// Pobieramy tylko dostępny sprzęt + relacje (żeby nie było N+1)
	$sprzety = Sprzet::with(['kategoria', 'producent'])
		->where('status_sprzetu', 'dostepny') // Warunek z Twojego seedera
		->latest()
		->get();

	$kategorie = Kategoria::has('sprzety')->get();
	$producenci = Producent::withCount('sprzety')->get();
	$statusy = StatusWypozyczenia::withCount('wypozyczenia')->get();
	$role = Rola::withCount('uzytkownicy')->get();
	$ostatnieWypozyczenia = Wypozyczenie::with(['uzytkownik', 'status', 'sprzety'])
		->latest('utworzono_data')
		->take(4)
		->get();
	$platnosci = Platnosc::latest('utworzono_data')->take(4)->get();
	$adresy = Adres::with('uzytkownik')->latest('uzytkownik_id')->take(4)->get();
	$zalaczniki = Zalacznik::latest('utworzono_data')->take(3)->get();
	$statystyki = [
		'sprzet' => Sprzet::count(),
		'dostepny' => Sprzet::where('status_sprzetu', 'dostepny')->count(),
		'wypozyczenia' => Wypozyczenie::count(),
		'klienci' => Uzytkownik::count(),
	];

	return view('welcome', compact(
		'sprzety',
		'kategorie',
		'producenci',
		'statusy',
		'role',
		'ostatnieWypozyczenia',
		'platnosci',
		'adresy',
		'zalaczniki',
		'statystyki'
	));
})->name('home');

// Koszyk
Route::get('/koszyk', [SklepController::class, 'koszyk'])->name('koszyk');

// Sklep - strona z produktami
Route::get('/sklep', [SklepController::class, 'index'])->name('sklep');
Route::get('/sklep/products', [SklepController::class, 'getProducts'])->name('sklep.products');
Route::get('/produkt/{sprzet}', [SklepController::class, 'show'])->name('produkt.show');

Route::post('/koszyk/dodaj', [SklepController::class, 'dodajDoKoszyka'])->name('koszyk.dodaj');
Route::post('/koszyk/usun/{index}', [SklepController::class, 'usunZKoszyka'])->name('koszyk.usun');
Route::post('/koszyk/aktualizuj', [SklepController::class, 'aktualizujDatyWKoszyku'])->name('koszyk.aktualizuj');
Route::post('/koszyk/zloz', [SklepController::class, 'zlozZamowienie'])->name('koszyk.zloz');

// O nas
Route::get('/o-nas', function () {
	return view('o-nas');
})->name('o-nas');

// Polityka prywatności
Route::get('/polityka-prywatnosci', function () {
	return view('polityka-prywatnosci');
})->name('polityka-prywatnosci');

// Logowanie / Rejestracja klienta
Route::get('/logowanie', [AuthController::class, 'showLoginForm'])->name('logowanie');
Route::post('/logowanie', [AuthController::class, 'login'])->name('logowanie.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/rejestracja', [AuthController::class, 'showRegisterForm'])->name('rejestracja');
Route::post('/rejestracja', [AuthController::class, 'register'])->name('rejestracja.store');

Route::get('/konto', [KontoController::class, 'index'])->middleware('auth')->name('konto');
Route::put('/konto', [KontoController::class, 'update'])->middleware('auth')->name('konto.update');
Route::post('/konto/{id}/przedluz', [KontoController::class, 'przedluz'])->middleware('auth')->name('konto.przedluz');
Route::post('/konto/{id}/anuluj', [KontoController::class, 'anuluj'])->middleware('auth')->name('konto.anuluj');

// Kontakt
Route::get('/kontakt', [KontaktController::class, 'index'])->name('kontakt');
Route::post('/kontakt', [KontaktController::class, 'store'])->name('kontakt.store');


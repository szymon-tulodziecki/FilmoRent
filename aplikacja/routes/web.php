
<?php

use Illuminate\Support\Facades\Route;
use App\Models\Sprzet;
use App\Models\Kategoria;

// Strona Główna - pobieramy sprzęt "na żywca" z Twoich modeli
Route::get('/', function () {
	// Pobieramy tylko dostępny sprzęt + relacje (żeby nie było N+1)
	$sprzety = Sprzet::with(['kategoria', 'producent'])
		->where('status_sprzetu', 'dostepny') // Warunek z Twojego seedera
		->latest()
		->get();

	$kategorie = Kategoria::has('sprzety')->get();

	return view('welcome', compact('sprzety', 'kategorie'));
})->name('home');

// Tymczasowy route do koszyka (żeby linki nie wywalały błędu 404)
Route::get('/koszyk', function () {
	return view('koszyk');
})->name('koszyk');

// Sklep - strona z produktami
Route::get('/sklep', function () {
	$sprzety = Sprzet::with(['kategoria', 'producent'])
		->where('status_sprzetu', 'dostepny')
		->latest()
		->get();

	$kategorie = Kategoria::has('sprzety')->get();

	return view('sklep', compact('sprzety', 'kategorie'));
})->name('sklep');

// O nas
Route::get('/o-nas', function () {
	return view('o-nas');
})->name('o-nas');

// Logowanie klienta
Route::get('/logowanie', function () {
	return view('logowanie');
})->name('logowanie');


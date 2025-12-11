<?php

namespace Database\Seeders;

use App\Models\Rola;
use App\Models\Uzytkownik;
use App\Models\Adres;
use App\Models\Kategoria;
use App\Models\Producent;
use App\Models\Sprzet;
use App\Models\StatusWypozyczenia;
use App\Models\Wypozyczenie;
use App\Models\Platnosc;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === ROLE ===
        $admin = Rola::create(['nazwa' => 'Administrator', 'klucz' => 'admin']);
        $pracownik = Rola::create(['nazwa' => 'Pracownik', 'klucz' => 'pracownik']);
        $klient = Rola::create(['nazwa' => 'Klient', 'klucz' => 'klient']);

        // === UŻYTKOWNICY ===
        $adminUser = Uzytkownik::create([
            'rola_id' => $admin->id,
            'imie' => 'Jan',
            'nazwisko' => 'Kowalski',
            'email' => 'admin@filmorent.pl',
            'haslo' => Hash::make('password'),
            'telefon' => '+48 500 100 200',
        ]);

        $pracownikUser = Uzytkownik::create([
            'rola_id' => $pracownik->id,
            'imie' => 'Anna',
            'nazwisko' => 'Nowak',
            'email' => 'pracownik@filmorent.pl',
            'haslo' => Hash::make('password'),
            'telefon' => '+48 500 100 201',
        ]);

        $klienci = [];
        $klientData = [
            ['imie' => 'Piotr', 'nazwisko' => 'Wiśniewski', 'email' => 'piotr@example.com'],
            ['imie' => 'Maria', 'nazwisko' => 'Wójcik', 'email' => 'maria@example.com'],
            ['imie' => 'Tomasz', 'nazwisko' => 'Kamiński', 'email' => 'tomasz@example.com'],
            ['imie' => 'Katarzyna', 'nazwisko' => 'Lewandowska', 'email' => 'kasia@example.com'],
            ['imie' => 'Michał', 'nazwisko' => 'Zieliński', 'email' => 'michal@example.com'],
        ];

        foreach ($klientData as $data) {
            $klienci[] = Uzytkownik::create([
                'rola_id' => $klient->id,
                'imie' => $data['imie'],
                'nazwisko' => $data['nazwisko'],
                'email' => $data['email'],
                'haslo' => Hash::make('password'),
                'telefon' => '+48 600 ' . rand(100, 999) . ' ' . rand(100, 999),
            ]);
        }

        // === ADRESY ===
        Adres::create([
            'uzytkownik_id' => $klienci[0]->id,
            'ulica' => 'ul. Filmowa 15/3',
            'miasto' => 'Warszawa',
            'kod_pocztowy' => '00-001',
            'typ' => 'rozliczeniowy',
        ]);

        Adres::create([
            'uzytkownik_id' => $klienci[1]->id,
            'ulica' => 'ul. Kinowa 22',
            'miasto' => 'Kraków',
            'kod_pocztowy' => '30-002',
            'typ' => 'dostawy',
        ]);

        // === KATEGORIE ===
        $kamery = Kategoria::create(['nazwa' => 'Kamery', 'slug' => 'kamery']);
        $obiektywy = Kategoria::create(['nazwa' => 'Obiektywy', 'slug' => 'obiektywy']);
        $oswietlenie = Kategoria::create(['nazwa' => 'Oświetlenie', 'slug' => 'oswietlenie']);
        $statywy = Kategoria::create(['nazwa' => 'Statywy i Gimbale', 'slug' => 'statywy-gimbale']);
        $audio = Kategoria::create(['nazwa' => 'Audio', 'slug' => 'audio']);

        // Podkategorie
        Kategoria::create(['nazwa' => 'Kamery Kinowe', 'slug' => 'kamery-kinowe', 'rodzic_id' => $kamery->id]);
        Kategoria::create(['nazwa' => 'Kamery Bezlusterkowe', 'slug' => 'kamery-bezlusterkowe', 'rodzic_id' => $kamery->id]);
        Kategoria::create(['nazwa' => 'Obiektywy Stałoogniskowe', 'slug' => 'obiektywy-staloogniskowe', 'rodzic_id' => $obiektywy->id]);
        Kategoria::create(['nazwa' => 'Obiektywy Zoom', 'slug' => 'obiektywy-zoom', 'rodzic_id' => $obiektywy->id]);

        // === PRODUCENCI ===
        $sony = Producent::create(['nazwa' => 'Sony', 'opis' => 'Japoński producent elektroniki']);
        $canon = Producent::create(['nazwa' => 'Canon', 'opis' => 'Japoński producent optyki i kamer']);
        $blackmagic = Producent::create(['nazwa' => 'Blackmagic Design', 'opis' => 'Australijski producent sprzętu filmowego']);
        $arri = Producent::create(['nazwa' => 'ARRI', 'opis' => 'Niemiecki producent kamer kinowych']);
        $aputure = Producent::create(['nazwa' => 'Aputure', 'opis' => 'Chiński producent oświetlenia LED']);
        $dji = Producent::create(['nazwa' => 'DJI', 'opis' => 'Chiński producent gimbali i dronów']);
        $rode = Producent::create(['nazwa' => 'RØDE', 'opis' => 'Australijski producent mikrofonów']);
        $manfrotto = Producent::create(['nazwa' => 'Manfrotto', 'opis' => 'Włoski producent statywów']);
        $zeiss = Producent::create(['nazwa' => 'ZEISS', 'opis' => 'Niemiecki producent optyki premium']);
        $sigma = Producent::create(['nazwa' => 'Sigma', 'opis' => 'Japoński producent obiektywów']);

        // === SPRZĘT (20 pozycji) ===
        $sprzetData = [
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'FX3 Full-Frame Cinema Camera', 'cena' => 350, 'kaucja' => 5000, 'wartosc' => 18000],
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'Alpha a7S III Body', 'cena' => 250, 'kaucja' => 4000, 'wartosc' => 15000],
            ['kategoria' => $kamery, 'producent' => $canon, 'nazwa' => 'EOS R5 Body', 'cena' => 280, 'kaucja' => 4500, 'wartosc' => 16000],
            ['kategoria' => $kamery, 'producent' => $canon, 'nazwa' => 'EOS C70 Cinema Camera', 'cena' => 400, 'kaucja' => 6000, 'wartosc' => 25000],
            ['kategoria' => $kamery, 'producent' => $blackmagic, 'nazwa' => 'Pocket Cinema Camera 6K Pro', 'cena' => 200, 'kaucja' => 3000, 'wartosc' => 10000],
            ['kategoria' => $kamery, 'producent' => $arri, 'nazwa' => 'ALEXA Mini LF', 'cena' => 1500, 'kaucja' => 20000, 'wartosc' => 85000],
            ['kategoria' => $obiektywy, 'producent' => $sony, 'nazwa' => 'FE 24-70mm f/2.8 GM II', 'cena' => 80, 'kaucja' => 1500, 'wartosc' => 9000],
            ['kategoria' => $obiektywy, 'producent' => $sony, 'nazwa' => 'FE 70-200mm f/2.8 GM OSS II', 'cena' => 90, 'kaucja' => 1800, 'wartosc' => 11000],
            ['kategoria' => $obiektywy, 'producent' => $zeiss, 'nazwa' => 'CP.3 50mm T2.1', 'cena' => 120, 'kaucja' => 2000, 'wartosc' => 12000],
            ['kategoria' => $obiektywy, 'producent' => $sigma, 'nazwa' => 'Art 35mm f/1.4 DG DN', 'cena' => 50, 'kaucja' => 800, 'wartosc' => 4000],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => '300d II LED Light', 'cena' => 100, 'kaucja' => 1200, 'wartosc' => 5000],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => '600d Pro LED Light', 'cena' => 150, 'kaucja' => 2000, 'wartosc' => 8000],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => 'MC 4-Light Travel Kit', 'cena' => 60, 'kaucja' => 800, 'wartosc' => 2500],
            ['kategoria' => $statywy, 'producent' => $manfrotto, 'nazwa' => 'MVH502AH Fluid Head + 546B Tripod', 'cena' => 40, 'kaucja' => 500, 'wartosc' => 2000],
            ['kategoria' => $statywy, 'producent' => $manfrotto, 'nazwa' => '504X Fluid Head + CF Twin Leg', 'cena' => 70, 'kaucja' => 1000, 'wartosc' => 4500],
            ['kategoria' => $statywy, 'producent' => $dji, 'nazwa' => 'RS 3 Pro Gimbal', 'cena' => 80, 'kaucja' => 1000, 'wartosc' => 3500],
            ['kategoria' => $statywy, 'producent' => $dji, 'nazwa' => 'Ronin 4D 6K Combo', 'cena' => 600, 'kaucja' => 8000, 'wartosc' => 35000],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'NTG5 Shotgun Microphone', 'cena' => 35, 'kaucja' => 400, 'wartosc' => 2000],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'Wireless GO II', 'cena' => 30, 'kaucja' => 350, 'wartosc' => 1500],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'VideoMic Pro+', 'cena' => 25, 'kaucja' => 300, 'wartosc' => 1200],
        ];

        foreach ($sprzetData as $i => $data) {
            Sprzet::create([
                'kategoria_id' => $data['kategoria']->id,
                'producent_id' => $data['producent']->id,
                'nazwa' => $data['nazwa'],
                'numer_seryjny' => 'SN-' . strtoupper(substr(md5($data['nazwa']), 0, 8)) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'opis' => 'Profesjonalny sprzęt filmowy - ' . $data['nazwa'],
                'cena_doba' => $data['cena'],
                'kaucja' => $data['kaucja'],
                'wartosc_rynkowa' => $data['wartosc'],
                'status_sprzetu' => $i === 5 ? 'w_serwisie' : 'dostepny', // ARRI w serwisie
            ]);
        }

        // === STATUSY WYPOŻYCZENIA ===
        StatusWypozyczenia::create(['nazwa' => 'Oczekuje na potwierdzenie', 'klucz' => 'oczekuje', 'kolor' => '#FFA500']);
        StatusWypozyczenia::create(['nazwa' => 'Potwierdzone', 'klucz' => 'potwierdzone', 'kolor' => '#4CAF50']);
        $wydane = StatusWypozyczenia::create(['nazwa' => 'Wydane', 'klucz' => 'wydane', 'kolor' => '#2196F3']);
        StatusWypozyczenia::create(['nazwa' => 'Zwrócone', 'klucz' => 'zwrocone', 'kolor' => '#9C27B0']);
        StatusWypozyczenia::create(['nazwa' => 'Zamknięte', 'klucz' => 'zamkniete', 'kolor' => '#607D8B']);
        StatusWypozyczenia::create(['nazwa' => 'Anulowane', 'klucz' => 'anulowane', 'kolor' => '#F44336']);
        StatusWypozyczenia::create(['nazwa' => 'Opóźnione', 'klucz' => 'opoznione', 'kolor' => '#E91E63']);

        // === PRZYKŁADOWE WYPOŻYCZENIE ===
        $sprzet1 = Sprzet::where('nazwa', 'like', '%FX3%')->first();
        $sprzet2 = Sprzet::where('nazwa', 'like', '%24-70mm%')->first();

        $wypozyczenie = Wypozyczenie::create([
            'numer_zamowienia' => 'RENT/2025/12/0001',
            'uzytkownik_id' => $klienci[0]->id,
            'pracownik_id' => $pracownikUser->id,
            'status_id' => $wydane->id,
            'data_rezerwacji' => now(),
            'data_odbioru' => now(),
            'data_zwrotu' => now()->addDays(3),
            'suma_calkowita' => ($sprzet1->cena_doba + $sprzet2->cena_doba) * 3 + $sprzet1->kaucja + $sprzet2->kaucja,
            'uwagi' => 'Klient prosi o naładowane baterie',
        ]);

        // Elementy wypożyczenia
        $wypozyczenie->sprzety()->attach([
            $sprzet1->id => ['cena_netto_snapshot' => $sprzet1->cena_doba, 'rabat_procent' => 0],
            $sprzet2->id => ['cena_netto_snapshot' => $sprzet2->cena_doba, 'rabat_procent' => 10],
        ]);

        // Płatność
        Platnosc::create([
            'wypozyczenie_id' => $wypozyczenie->id,
            'kwota' => $wypozyczenie->suma_calkowita,
            'typ' => 'kaucja',
            'metoda' => 'karta',
            'status' => 'zrealizowana',
        ]);
    }
}

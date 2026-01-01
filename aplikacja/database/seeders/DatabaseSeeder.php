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
        $admin = Rola::updateOrCreate(['klucz' => 'admin'], ['nazwa' => 'Administrator']);
        $pracownik = Rola::updateOrCreate(['klucz' => 'pracownik'], ['nazwa' => 'Pracownik']);
        $klient = Rola::updateOrCreate(['klucz' => 'klient'], ['nazwa' => 'Klient']);

        // === UŻYTKOWNICY ===
        // Administrator - pełny dostęp do systemu
        $adminUser = Uzytkownik::updateOrCreate(
            ['email' => 'admin@filmorent.pl'],
            [
                'rola_id' => $admin->id,
                'imie' => 'Jan',
                'nazwisko' => 'Kowalski',
                'haslo' => Hash::make('Admin123!'),
                'telefon' => '+48 500 100 200',
                'typ_klienta' => 'indywidualny',
                'pesel' => '00000000000',
                'status_klienta' => 'aktywny',
                'zweryfikowany_email_data' => now(),
            ]
        );

        // Pracownik - zarządzanie wypożyczeniami
        $pracownikUser = Uzytkownik::updateOrCreate(
            ['email' => 'pracownik@filmorent.pl'],
            [
                'rola_id' => $pracownik->id,
                'imie' => 'Anna',
                'nazwisko' => 'Nowak',
                'haslo' => Hash::make('Pracownik123!'),
                'telefon' => '+48 500 100 201',
                'typ_klienta' => 'indywidualny',
                'pesel' => '11111111111',
                'status_klienta' => 'aktywny',
                'zweryfikowany_email_data' => now(),
            ]
        );

        // Klient - przeglądanie i rezerwacje
        $klientUser = Uzytkownik::updateOrCreate(
            ['email' => 'klient@filmorent.pl'],
            [
                'rola_id' => $klient->id,
                'imie' => 'Piotr',
                'nazwisko' => 'Wiśniewski',
                'haslo' => Hash::make('Klient123!'),
                'telefon' => '+48 500 100 202',
                'typ_klienta' => 'indywidualny',
                'pesel' => '11223344556',
                'status_klienta' => 'aktywny',
                'zweryfikowany_email_data' => now(),
            ]
        );

        $klienci = [];
        $klientData = [
            ['imie' => 'Maria', 'nazwisko' => 'Wójcik', 'email' => 'maria@example.com', 'typ_klienta' => 'indywidualny', 'pesel' => '12345678901'],
            ['imie' => 'Tomasz', 'nazwisko' => 'Kamiński', 'email' => 'tomasz@example.com', 'typ_klienta' => 'indywidualny', 'pesel' => '98765432109'],
            ['imie' => 'Katarzyna', 'nazwisko' => 'Lewandowska', 'email' => 'kasia@example.com', 'typ_klienta' => 'biznesowy', 'nazwa_firmy' => 'Studio Filmowe Lewandowski', 'nip' => '1234567890', 'regon' => '356789123'],
            ['imie' => 'Michał', 'nazwisko' => 'Zieliński', 'email' => 'michal@example.com', 'typ_klienta' => 'biznesowy', 'nazwa_firmy' => 'Produkcja Zielone Kadry', 'nip' => '0987654321', 'regon' => '12345678901234'],
            ['imie' => 'Paulina', 'nazwisko' => 'Domańska', 'email' => 'paulina@example.com', 'typ_klienta' => 'indywidualny', 'pesel' => '19283746509'],
            ['imie' => 'Grzegorz', 'nazwisko' => 'Baran', 'email' => 'grzegorz@example.com', 'typ_klienta' => 'biznesowy', 'nazwa_firmy' => 'Sky Vision Films', 'nip' => '2223334445', 'regon' => '87654321098765'],
        ];

        foreach ($klientData as $data) {
            $userData = [
                'rola_id' => $klient->id,
                'imie' => $data['imie'],
                'nazwisko' => $data['nazwisko'],
                'haslo' => Hash::make('password'),
                'telefon' => '+48 600 ' . rand(100, 999) . ' ' . rand(100, 999),
                'typ_klienta' => $data['typ_klienta'],
                'status_klienta' => 'aktywny',
            ];

            if ($data['typ_klienta'] === 'indywidualny') {
                $userData['pesel'] = $data['pesel'];
            } else {
                $userData['nazwa_firmy'] = $data['nazwa_firmy'];
                $userData['nip'] = $data['nip'];
                $userData['regon'] = $data['regon'] ?? null;
                $userData['osoba_kontaktowa'] = $data['imie'] . ' ' . $data['nazwisko'];
                $userData['stanowisko'] = 'Kierownik Produkcji';
                $userData['notatki_crm'] = 'Klient korporacyjny z regularnym wolumenem zamówień';
            }

            $klienci[] = Uzytkownik::updateOrCreate(
                ['email' => $data['email']],
                $userData
            );
        }

        // === ADRESY ===
        if (!empty($klienci)) {
            Adres::updateOrCreate(
                ['uzytkownik_id' => $klienci[0]->id, 'typ' => 'rozliczeniowy'],
                [
                    'ulica' => 'ul. Filmowa 15/3',
                    'miasto' => 'Warszawa',
                    'kod_pocztowy' => '00-001',
                ]
            );

            Adres::updateOrCreate(
                ['uzytkownik_id' => $klienci[1]->id, 'typ' => 'dostawy'],
                [
                    'ulica' => 'ul. Kinowa 22',
                    'miasto' => 'Kraków',
                    'kod_pocztowy' => '30-002',
                ]
            );

            Adres::updateOrCreate(
                ['uzytkownik_id' => $klienci[2]->id, 'typ' => 'rozliczeniowy'],
                [
                    'ulica' => 'ul. Produkcyjna 9',
                    'miasto' => 'Poznań',
                    'kod_pocztowy' => '60-123',
                ]
            );

            Adres::updateOrCreate(
                ['uzytkownik_id' => $klienci[3]->id, 'typ' => 'dostawy'],
                [
                    'ulica' => 'ul. Kreatywna 21',
                    'miasto' => 'Gdańsk',
                    'kod_pocztowy' => '80-400',
                ]
            );
        }

        // === KATEGORIE ===
        $kamery = Kategoria::updateOrCreate(
            ['slug' => 'kamery'], 
            [
                'nazwa' => 'Kamery',
                'slowa_kluczowe' => 'aparat, kamera, kamera cyfrowa, kamera filmowa, kamera video, kamera 4k, kamera hd'
            ]
        );
        $obiektywy = Kategoria::updateOrCreate(
            ['slug' => 'obiektywy'], 
            [
                'nazwa' => 'Obiektywy',
                'slowa_kluczowe' => 'obiektyw, lens, zoom, tele, wide, 50mm, 24mm, 85mm'
            ]
        );
        $oswietlenie = Kategoria::updateOrCreate(
            ['slug' => 'oswietlenie'], 
            [
                'nazwa' => 'Oświetlenie',
                'slowa_kluczowe' => 'światło, oświetlenie, lampa, led, reflektor, panel, softbox, ring light'
            ]
        );
        $statywy = Kategoria::updateOrCreate(
            ['slug' => 'statywy-gimbale'], 
            [
                'nazwa' => 'Statywy i Gimbale',
                'slowa_kluczowe' => 'statyw, gimbal, stabilizator, gimbal ręczny, statyw fotograficzny, stojak'
            ]
        );
        $audio = Kategoria::updateOrCreate(
            ['slug' => 'audio'], 
            [
                'nazwa' => 'Audio',
                'slowa_kluczowe' => 'mikrofon, dźwięk, audio, recorder, rejestrator, słuchawki, nagłośnienie'
            ]
        );

        // Podkategorie
        Kategoria::updateOrCreate(
            ['slug' => 'kamery-kinowe'], 
            [
                'nazwa' => 'Kamery Kinowe', 
                'rodzic_id' => $kamery->id,
                'slowa_kluczowe' => 'kamera kinowa, cinema camera, alexa, red, fx30'
            ]
        );
        Kategoria::updateOrCreate(
            ['slug' => 'kamery-bezlusterkowe'], 
            [
                'nazwa' => 'Kamery Bezlusterkowe', 
                'rodzic_id' => $kamery->id,
                'slowa_kluczowe' => 'bezlusterkowiec, mirrorless, sony, canon, nikon'
            ]
        );
        Kategoria::updateOrCreate(
            ['slug' => 'obiektywy-staloogniskowe'], 
            [
                'nazwa' => 'Obiektywy Stałoogniskowe', 
                'rodzic_id' => $obiektywy->id,
                'slowa_kluczowe' => 'prime, stały, 50mm, 35mm, 85mm, 24mm'
            ]
        );
        Kategoria::updateOrCreate(
            ['slug' => 'obiektywy-zoom'], 
            [
                'nazwa' => 'Obiektywy Zoom', 
                'rodzic_id' => $obiektywy->id,
                'slowa_kluczowe' => 'zoom, zmiennoogniskowy, 18-55, 24-70, telezoom'
            ]
        );

        // === PRODUCENCI ===
        $sony = Producent::updateOrCreate(['nazwa' => 'Sony'], ['opis' => 'Japoński producent elektroniki']);
        $canon = Producent::updateOrCreate(['nazwa' => 'Canon'], ['opis' => 'Japoński producent optyki i kamer']);
        $blackmagic = Producent::updateOrCreate(['nazwa' => 'Blackmagic Design'], ['opis' => 'Australijski producent sprzętu filmowego']);
        $arri = Producent::updateOrCreate(['nazwa' => 'ARRI'], ['opis' => 'Niemiecki producent kamer kinowych']);
        $aputure = Producent::updateOrCreate(['nazwa' => 'Aputure'], ['opis' => 'Chiński producent oświetlenia LED']);
        $dji = Producent::updateOrCreate(['nazwa' => 'DJI'], ['opis' => 'Chiński producent gimbali i dronów']);
        $rode = Producent::updateOrCreate(['nazwa' => 'RØDE'], ['opis' => 'Australijski producent mikrofonów']);
        $manfrotto = Producent::updateOrCreate(['nazwa' => 'Manfrotto'], ['opis' => 'Włoski producent statywów']);
        $zeiss = Producent::updateOrCreate(['nazwa' => 'ZEISS'], ['opis' => 'Niemiecki producent optyki premium']);
        $sigma = Producent::updateOrCreate(['nazwa' => 'Sigma'], ['opis' => 'Japoński producent obiektywów']);

        // === SPRZĘT (35+ pozycji) z rozbudowanymi opisami ===
        $sprzetData = [
            // KAMERY
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'FX3 Full-Frame Cinema Camera', 'cena' => 350, 'kaucja' => 5000, 'wartosc' => 18000, 'url' => null, 
             'opis' => 'Profesjonalna kamera kinowa z pełnoklatkową matrycą 10.2MP. Zoptymalizowana do produkcji wideo z 15+ stopami dynamiki, 4K 120fps, S-Log3, dual ISO i aktywną stabilizacją. Idealna do dokumentów, reklam i produkcji kinowych.'],
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'Alpha a7S III Body', 'cena' => 250, 'kaucja' => 4000, 'wartosc' => 15000, 'url' => null,
             'opis' => 'Bestia do low-light video. Pełnoklatkowa matryca 12MP, 4K 120fps, 10-bit 4:2:2, S-Log3. Zaawansowany AF z eye-tracking, 5-axis stabilizacja. Rewelacyjna w ciemnych warunkach dzięki dual native ISO.'],
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'FX30 Cinema Camera', 'cena' => 200, 'kaucja' => 3000, 'wartosc' => 12000, 'url' => null,
             'opis' => 'Kompaktowa kamera kinowa APS-C Super 35. Matryca 26MP, 4K 120fps oversampled, 14+ stopni dynamiki. Bez limitu nagrywania, dual base ISO, XLR audio. Doskonała do eventów, korporacyjnych i social media.'],
            ['kategoria' => $kamery, 'producent' => $sony, 'nazwa' => 'Alpha a6700 Body', 'cena' => 180, 'kaucja' => 2800, 'wartosc' => 10000, 'url' => null,
             'opis' => 'Wszechstronna kamera APS-C. Matryca 26MP, 4K 60fps oversampled, 10-bit 4:2:2, S-Log3. AI-powered AF, aktywna stabilizacja. Kompaktowa, mobilna - idealna do vlogów, eventów i fast-paced produkcji.'],
            ['kategoria' => $kamery, 'producent' => $canon, 'nazwa' => 'EOS R5 Body', 'cena' => 280, 'kaucja' => 4500, 'wartosc' => 16000, 'url' => null,
             'opis' => 'Hybrydowa bestia full-frame 45MP. Nagrywanie 8K RAW, 4K 120fps, Canon Log 3, dual pixel AF II. 5-axis IBIS, 20fps burst. Premium build quality, perfekcyjna do high-end commercial i fashion.'],
            ['kategoria' => $kamery, 'producent' => $canon, 'nazwa' => 'EOS C70 Cinema Camera', 'cena' => 400, 'kaucja' => 6000, 'wartosc' => 25000, 'url' => null,
             'opis' => 'Kompaktowa kamera kinowa Super 35. DGO sensor (16 stopni dynamiki!), 4K 120fps, Canon Log 2/3, dual gain output. Built-in ND filters, XLR audio, RF mount. Rewolucyjna jakość w małym body.'],
            ['kategoria' => $kamery, 'producent' => $canon, 'nazwa' => 'EOS R6 Mark II Body', 'cena' => 200, 'kaucja' => 3500, 'wartosc' => 12000, 'url' => null,
             'opis' => 'Wszechstronna full-frame 24MP. 4K 60fps bez crop, Canon Log 3, 6K oversampled. Zaawansowany AF, 5-axis IBIS, 40fps burst. Bez limitu nagrywania. Świetna do eventów, ślubów i fast production.'],
            ['kategoria' => $kamery, 'producent' => $blackmagic, 'nazwa' => 'Pocket Cinema Camera 6K Pro', 'cena' => 200, 'kaucja' => 3000, 'wartosc' => 10000, 'url' => null,
             'opis' => 'Kino w kieszeni! Super 35 sensor 6K, 13 stopni dynamiki, Blackmagic RAW. Wbudowane ND filtry, dual native ISO, ProRes/BRAW. Flip-out touchscreen, XLR audio. Naturalna kolorystyka, idealna do gradingu.'],
            ['kategoria' => $kamery, 'producent' => $blackmagic, 'nazwa' => 'Blackmagic URSA Mini Pro 12K', 'cena' => 800, 'kaucja' => 12000, 'wartosc' => 50000, 'url' => null,
             'opis' => '12K resolution! 80MP Super 35 sensor, 14 stopni dynamiki, Blackmagic RAW. Built-in ND, dual CFast/SD, XLR audio. Niesamowita szczegółowość dla VFX, commercial i kinematografii. Doskonała reputacja na rynku.'],
            ['kategoria' => $kamery, 'producent' => $arri, 'nazwa' => 'ALEXA Mini LF', 'cena' => 1500, 'kaucja' => 20000, 'wartosc' => 85000, 'url' => null,
             'opis' => 'Hollywood standard! Large format sensor 4.5K, 14+ stopni dynamiki, ARRI color science. Compact cinema body, ProRes/ARRIRAW. Legendarna kolorystyka i skin tones. Top choice dla feature films, high-end commercial.'],
            ['kategoria' => $kamery, 'producent' => $arri, 'nazwa' => 'ALEXA 35', 'cena' => 2000, 'kaucja' => 30000, 'wartosc' => 120000, 'url' => null,
             'opis' => 'Najnowsza ARRI. Super 35 sensor 4.6K, 17 stopni dynamiki (!), REVEAL Color Science. Enhanced sensitivity, texture mode, 120fps. Netflix approved. Absolutny szczyt technologii kinowej.'],
            
            // OBIEKTYWY
            ['kategoria' => $obiektywy, 'producent' => $sony, 'nazwa' => 'FE 24-70mm f/2.8 GM II', 'cena' => 80, 'kaucja' => 1500, 'wartosc' => 9000, 'url' => null,
             'opis' => 'Flagowy zoom Sony. Niezwykle ostry corner-to-corner, najlżejszy f/2.8 w klasie (695g). XA elements, nano coating. Szybki AF, minimalne breathing. Wszechstronny workhorse do eventów, ślubów, commercial.'],
            ['kategoria' => $obiektywy, 'producent' => $sony, 'nazwa' => 'FE 70-200mm f/2.8 GM OSS II', 'cena' => 90, 'kaucja' => 1800, 'wartosc' => 11000, 'url' => null,
             'opis' => 'Telezoom profesjonalny. Optyczna perfekcja, szybki AF, optical stabilization. Świetny do portretów, sportów, wildlife. Bokeh jak z prime. Weather sealed, fluorine coating. Must-have w każdym zestawie.'],
            ['kategoria' => $obiektywy, 'producent' => $sony, 'nazwa' => 'FE 14mm f/1.8 GM', 'cena' => 85, 'kaucja' => 1600, 'wartosc' => 8500, 'url' => null,
             'opis' => 'Najszybszy ultra-wide. f/1.8 przy 14mm to magia! Minimal distortion, edge-to-edge sharpness. Idealne do astro, architektury, landscapes. 11-blade aperture = piękne sunstars. Premium glass.'],
            ['kategoria' => $obiektywy, 'producent' => $canon, 'nazwa' => 'RF 24-70mm f/2.8L IS USM', 'cena' => 75, 'kaucja' => 1400, 'wartosc' => 8000, 'url' => null,
             'opis' => 'Wszechstronny zoom Canon RF. Optical IS (5.5 stops!), nano USM AF, weather sealed. UD/Aspherical elements, Air Sphere coating. Szybki focus, minimalne breathing. Pro workhorse.'],
            ['kategoria' => $obiektywy, 'producent' => $canon, 'nazwa' => 'RF 70-200mm f/2.8L IS USM', 'cena' => 95, 'kaucja' => 1900, 'wartosc' => 11500, 'url' => null,
             'opis' => 'Kompaktowy telezoom. Rewolucyjna optyka - 1kg lżejszy niż konkurencja. Optical IS, nano USM, weather sealed. Ostry, szybki, precyzyjny. Ideał do eventów, portretów, sports.'],
            ['kategoria' => $obiektywy, 'producent' => $zeiss, 'nazwa' => 'CP.3 50mm T2.1', 'cena' => 120, 'kaucja' => 2000, 'wartosc' => 12000, 'url' => null,
             'opis' => 'Obiektyw kinowy Zeiss. T2.1, focus gears, cinema housing. Matched color across set, minimal breathing, smooth focus pull. Legendary Zeiss look - organic, pleasing. Standard na produkcjach.'],
            ['kategoria' => $obiektywy, 'producent' => $zeiss, 'nazwa' => 'CP.3 35mm T2.1', 'cena' => 120, 'kaucja' => 2000, 'wartosc' => 12000, 'url' => null,
             'opis' => 'Cinema wide Zeiss CP.3. T2.1, cinema mechanics, matched optics. Full-frame coverage, minimal distortion. Natural perspective dla narracji. Skin tones płynne i naturalne.'],
            ['kategoria' => $obiektywy, 'producent' => $zeiss, 'nazwa' => 'CP.3 85mm T2.1', 'cena' => 120, 'kaucja' => 2000, 'wartosc' => 12000, 'url' => null,
             'opis' => 'Portretowy cinema lens. T2.1, smooth bokeh, cinema build. Idealny do close-ups, interviews, beauty shots. Zeiss magic - pleasing skin tones, organic rendering. Industry favorite.'],
            ['kategoria' => $obiektywy, 'producent' => $sigma, 'nazwa' => 'Art 35mm f/1.4 DG DN', 'cena' => 50, 'kaucja' => 800, 'wartosc' => 4000, 'url' => null,
             'opis' => 'Rewelacyjny prime za rozsądną kasę. f/1.4, ultra sharp, minimal coma. Świetny do low-light, street, documentary. Szybki AF, weather-resistant. Legendarny Sigma Art quality w mirrorless.'],
            ['kategoria' => $obiektywy, 'producent' => $sigma, 'nazwa' => 'Art 24mm f/1.4 DG DN', 'cena' => 48, 'kaucja' => 800, 'wartosc' => 3800, 'url' => null,
             'opis' => 'Wide prime Sigma Art. f/1.4, corner-to-corner sharpness, minimal distortion. Uniwersalny do landscapes, events, astro. Solid build, fast AF. Najlepszy stosunek cena/jakość w klasie.'],
            
            // OŚWIETLENIE
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => '300d II LED Light', 'cena' => 100, 'kaucja' => 1200, 'wartosc' => 5000, 'url' => null,
             'opis' => 'Mocna lampa LED 300W. 5500K daylight, CRI 96+, TLCI 97+. Wireless control, 8 FX modes. Bowens mount - kompatybilne z light shapers. Ciche, stabilne, industry standard.'],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => '600d Pro LED Light', 'cena' => 150, 'kaucja' => 2000, 'wartosc' => 8000, 'url' => null,
             'opis' => 'Potężne 600W LED. Daylight balanced, CRI 96+, TLCI 98+. Sidus Link control, DMX, 9 FX modes. Equivalent do 1200W HMI. Pro build, cooling system. Stadium gig quality.'],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => 'MC 4-Light Travel Kit', 'cena' => 60, 'kaucja' => 800, 'wartosc' => 2500, 'url' => null,
             'opis' => 'Kompaktowe RGB LED mini. RGBWW, CRI 96+, 3200-6500K + full color. Built-in effects, magnetic mount. Pocket-sized, powerbank powered. Idealne do accent lighting, car shots, creative FX.'],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => '120D Mark 4.4 LED Panel', 'cena' => 70, 'kaucja' => 900, 'wartosc' => 3500, 'url' => null,
             'opis' => 'Kompaktowy panel 120W. Daylight 5500K, CRI 96+. Wireless mesh network, 8 FX modes. Compact, lightweight, Bowens mount. Świetny jako fill, key dla interviews, run-and-gun.'],
            ['kategoria' => $oswietlenie, 'producent' => $aputure, 'nazwa' => 'MC RGBWW LED Light 4-pack', 'cena' => 55, 'kaucja' => 700, 'wartosc' => 2200, 'url' => null,
             'opis' => '4x mini RGB powerhouses. Full RGBWW spectrum, app control, 9 FX modes. Magnetic, 1/4" mount, USB-C charging. Ultra portable. Perfect dla creative lighting, practicals, background accents.'],
            
            // STATYWY I GIMBALE
            ['kategoria' => $statywy, 'producent' => $manfrotto, 'nazwa' => 'MVH502AH Fluid Head + 546B Tripod', 'cena' => 40, 'kaucja' => 500, 'wartosc' => 2000, 'url' => null,
             'opis' => 'Solidny video tripod. Fluid head z counterbalance, smooth pan/tilt. Twin leg system, mid-level spreader. Udźwig do 7kg. Niezawodny workhorse do eventów, interviews, standard shooting.'],
            ['kategoria' => $statywy, 'producent' => $manfrotto, 'nazwa' => '504X Fluid Head + CF Twin Leg', 'cena' => 70, 'kaucja' => 1000, 'wartosc' => 4500, 'url' => null,
             'opis' => 'Pro carbon fiber system. Flat base head, continuous counterbalance, płynne ruchy. CF legs - ultra light, rigid. Udźwig 12kg. Top quality dla cinema, commercial, documentary.'],
            ['kategoria' => $statywy, 'producent' => $manfrotto, 'nazwa' => 'Aluminum Tripod with 055 Head', 'cena' => 35, 'kaucja' => 450, 'wartosc' => 1800, 'url' => null,
             'opis' => 'Uniwersalny foto/video tripod. Solidny aluminum, quick release plate, horizontal column. Udźwig 9kg. Versatile - od timelapse po video. Budget-friendly pro choice.'],
            ['kategoria' => $statywy, 'producent' => $dji, 'nazwa' => 'RS 3 Pro Gimbal', 'cena' => 80, 'kaucja' => 1000, 'wartosc' => 3500, 'url' => null,
             'opis' => 'Profesjonalny gimbal 3-axis. Udźwig 4.5kg, automated axis locks, carbon fiber. 1.8" OLED touchscreen, LiDAR + ActiveTrack. 12h battery. Smooth, powerful, reliable. Industry standard.'],
            ['kategoria' => $statywy, 'producent' => $dji, 'nazwa' => 'Ronin 4D 6K Combo', 'cena' => 600, 'kaucja' => 8000, 'wartosc' => 35000, 'url' => null,
             'opis' => 'Rewolucja: kamera + gimbal w jednym! 6K full-frame, 4-axis stabilization, LiDAR focus. ProRes RAW, 14+ stops DR. All-in-one cinema solution. Zmienia zasady gry w handheld cinema.'],
            ['kategoria' => $statywy, 'producent' => $dji, 'nazwa' => 'RS 3 Mini 3-Axis Gimbal', 'cena' => 50, 'kaucja' => 600, 'wartosc' => 2500, 'url' => null,
             'opis' => 'Kompaktowy gimbal. Udźwig 2kg, native vertical, Bluetooth shutter control. 10h battery, lightweight (795g). Perfect dla mirrorless, vlogów, travel shoots. Mobilny, szybki setup.'],
            
            // AUDIO
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'NTG5 Shotgun Microphone', 'cena' => 35, 'kaucja' => 400, 'wartosc' => 2000, 'url' => null,
             'opis' => 'Premium shotgun mic. RF-bias technology (niższysz hum!), lightweight acoustic design. High sensitivity, low noise. Weather-resistant, 10-year warranty. Broadcast quality dla dialogue, interviews.'],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'Wireless GO II', 'cena' => 30, 'kaucja' => 350, 'wartosc' => 1500, 'url' => null,
             'opis' => 'Dual wireless mic system. 2x transmitters + receiver, 200m range, 7h battery. Built-in recording (backup!), USB-C charging. Ultra compact. Rewelacja do interviews, documentary, vlogów.'],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'VideoMic Pro+', 'cena' => 25, 'kaucja' => 300, 'wartosc' => 1200, 'url' => null,
             'opis' => 'On-camera shotgun. Rechargeable battery (100h!), +20dB gain, high-pass filter. Rycote Lyre shock mount, foam + furry windshield. Auto power on/off. Reliable run-and-gun audio.'],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'Lavalier GO Wireless Mic', 'cena' => 20, 'kaucja' => 250, 'wartosc' => 1000, 'url' => null,
             'opis' => 'Omnidirectional lav mic. Compatible z Wireless GO, low profile, discreet. Flat frequency 20Hz-20kHz. MiCon connector system. Perfect dla interviews, presentations, documentary work.'],
            ['kategoria' => $audio, 'producent' => $rode, 'nazwa' => 'NT-SF1 Surround Microphone', 'cena' => 45, 'kaucja' => 500, 'wartosc' => 2500, 'url' => null,
             'opis' => 'Ambisonic A-format mic. 4x kondensery, spatial audio capture. 360° soundfield. Perfect dla VR, immersive content, ambience recording. Future-proof dla spatial audio workflows.'],
        ];

        foreach ($sprzetData as $i => $data) {
            Sprzet::updateOrCreate(
                ['nazwa' => $data['nazwa'], 'producent_id' => $data['producent']->id],
                [
                    'kategoria_id' => $data['kategoria']->id,
                    'numer_seryjny' => 'SN-' . strtoupper(substr(md5($data['nazwa']), 0, 8)) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'opis' => $data['opis'],
                    'cena_doba' => $data['cena'],
                    'kaucja' => $data['kaucja'],
                    'wartosc_rynkowa' => $data['wartosc'],
                    'status_sprzetu' => $i === 5 ? 'w_serwisie' : 'dostepny', // ARRI w serwisie
                    'url_zdjecia' => $data['url'], // null = auto Unsplash
                ]
            );
        }

        // === STATUSY WYPOŻYCZENIA ===
        $oczekuje = StatusWypozyczenia::updateOrCreate(['klucz' => 'oczekuje'], ['nazwa' => 'Oczekuje na potwierdzenie', 'kolor' => '#FFA500']);
        $wRealizacji = StatusWypozyczenia::updateOrCreate(['klucz' => 'wRealizacji'], ['nazwa' => 'W realizacji', 'kolor' => '#3B82F6']);
        $wysylka = StatusWypozyczenia::updateOrCreate(['klucz' => 'wysylka'], ['nazwa' => 'Wysyłka', 'kolor' => '#8B5CF6']);
        $wydane = StatusWypozyczenia::updateOrCreate(['klucz' => 'wydane'], ['nazwa' => 'Wydane', 'kolor' => '#2196F3']);
        $zwrocone = StatusWypozyczenia::updateOrCreate(['klucz' => 'zwrocone'], ['nazwa' => 'Zwrócone', 'kolor' => '#9C27B0']);
        $zrealizowane = StatusWypozyczenia::updateOrCreate(['klucz' => 'zrealizowane'], ['nazwa' => 'Zrealizowane', 'kolor' => '#10B981']);
        $zamkniete = StatusWypozyczenia::updateOrCreate(['klucz' => 'zamkniete'], ['nazwa' => 'Zamknięte', 'kolor' => '#607D8B']);
        $anulowane = StatusWypozyczenia::updateOrCreate(['klucz' => 'anulowane'], ['nazwa' => 'Anulowane', 'kolor' => '#F44336']);
        $opoznione = StatusWypozyczenia::updateOrCreate(['klucz' => 'opoznione'], ['nazwa' => 'Opóźnione', 'kolor' => '#E91E63']);

        // === PRZYKŁADOWE WYPOŻYCZENIA ===
        // Ustal pracownika - jeśli jest tylko jeden, przypisz do niego wszystkie zamówienia
        $allWorkers = Uzytkownik::whereHas('rola', function ($q) {
            $q->whereIn('klucz', ['pracownik', 'admin']);
        })->get();
        $assignedWorker = $allWorkers->count() === 1 ? $allWorkers->first() : $pracownikUser;

        $sprzetFx3 = Sprzet::where('nazwa', 'like', '%FX3%')->first();
        $sprzet2470 = Sprzet::where('nazwa', 'like', '%24-70mm%')->first();
        $sprzetGimbal = Sprzet::where('nazwa', 'like', '%RS 3 Pro%')->first();
        $sprzetAlexa = Sprzet::where('nazwa', 'like', '%ALEXA Mini%')->first();
        $sprzetLed = Sprzet::where('nazwa', 'like', '%300d II%')->first();

        // Zamówienie 1 - wydane, klient indywidualny
        if ($sprzetFx3 && $sprzet2470) {
            $suma = ($sprzetFx3->cena_doba + $sprzet2470->cena_doba) * 3 + $sprzetFx3->kaucja + $sprzet2470->kaucja;
            $wypozyczenie = Wypozyczenie::updateOrCreate(
                ['numer_zamowienia' => 'RENT/2026/01/0001'],
                [
                    'uzytkownik_id' => $klienci[0]->id,
                    'pracownik_id' => $assignedWorker->id,
                    'status_id' => $wydane->id,
                    'data_rezerwacji' => now()->subDays(2),
                    'data_odbioru' => now()->subDay(),
                    'data_zwrotu' => now()->addDays(2),
                    'suma_calkowita' => $suma,
                    'uwagi' => 'Klient prosi o naładowane baterie',
                ]
            );
            $wypozyczenie->sprzety()->syncWithoutDetaching([
                $sprzetFx3->id => ['cena_netto_snapshot' => $sprzetFx3->cena_doba, 'rabat_procent' => 0],
                $sprzet2470->id => ['cena_netto_snapshot' => $sprzet2470->cena_doba, 'rabat_procent' => 5],
            ]);
            Platnosc::updateOrCreate(
                ['wypozyczenie_id' => $wypozyczenie->id, 'typ' => 'kaucja'],
                [
                    'kwota' => $suma,
                    'metoda' => 'karta',
                    'status' => 'zrealizowana',
                ]
            );
        }

        // Zamówienie 2 - w realizacji, klient biznesowy
        if ($sprzetGimbal && $sprzetLed) {
            $suma2 = ($sprzetGimbal->cena_doba + $sprzetLed->cena_doba) * 2 + $sprzetGimbal->kaucja + $sprzetLed->kaucja;
            $wypozyczenie2 = Wypozyczenie::updateOrCreate(
                ['numer_zamowienia' => 'RENT/2026/01/0002'],
                [
                    'uzytkownik_id' => $klienci[2]->id,
                    'pracownik_id' => $assignedWorker->id,
                    'status_id' => $wRealizacji->id,
                    'data_rezerwacji' => now(),
                    'data_odbioru' => now()->addDay(),
                    'data_zwrotu' => now()->addDays(3),
                    'suma_calkowita' => $suma2,
                    'uwagi' => 'Wymagany softbox + statyw light stand',
                ]
            );
            $wypozyczenie2->sprzety()->syncWithoutDetaching([
                $sprzetGimbal->id => ['cena_netto_snapshot' => $sprzetGimbal->cena_doba, 'rabat_procent' => 0],
                $sprzetLed->id => ['cena_netto_snapshot' => $sprzetLed->cena_doba, 'rabat_procent' => 0],
            ]);
            Platnosc::updateOrCreate(
                ['wypozyczenie_id' => $wypozyczenie2->id, 'typ' => 'kaucja'],
                [
                    'kwota' => $suma2,
                    'metoda' => 'przelew',
                    'status' => 'oczekujaca',
                ]
            );
        }

        // Zamówienie 3 - oczekuje, klient biznesowy premium (ARRI)
        if ($sprzetAlexa && $sprzet2470) {
            $suma3 = ($sprzetAlexa->cena_doba + $sprzet2470->cena_doba) * 5 + $sprzetAlexa->kaucja + $sprzet2470->kaucja;
            $wypozyczenie3 = Wypozyczenie::updateOrCreate(
                ['numer_zamowienia' => 'RENT/2026/01/0003'],
                [
                    'uzytkownik_id' => $klienci[5]->id ?? $klienci[3]->id,
                    'pracownik_id' => $assignedWorker->id,
                    'status_id' => $oczekuje->id,
                    'data_rezerwacji' => now()->subDay(),
                    'data_odbioru' => now()->addDays(2),
                    'data_zwrotu' => now()->addDays(7),
                    'suma_calkowita' => $suma3,
                    'uwagi' => 'Plan zdjęciowy reklamy TV, potrzebny asystent kamery.',
                ]
            );
            $wypozyczenie3->sprzety()->syncWithoutDetaching([
                $sprzetAlexa->id => ['cena_netto_snapshot' => $sprzetAlexa->cena_doba, 'rabat_procent' => 0],
                $sprzet2470->id => ['cena_netto_snapshot' => $sprzet2470->cena_doba, 'rabat_procent' => 0],
            ]);
            Platnosc::updateOrCreate(
                ['wypozyczenie_id' => $wypozyczenie3->id, 'typ' => 'kaucja'],
                [
                    'kwota' => $suma3,
                    'metoda' => 'karta',
                    'status' => 'oczekujaca',
                ]
            );
        }
    }
}

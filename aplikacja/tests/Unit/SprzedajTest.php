<?php

namespace Tests\Unit;

use App\Models\Sprzet;
use App\Models\Kategoria;
use App\Models\Producent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprzedajTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Tworzenie nowego sprzętu z prawidłowymi danymi
     */
    public function test_mozna_utworzyc_sprzet_z_prawidlowymi_danymi()
    {
        $kategoria = Kategoria::create(['nazwa' => 'Kamery', 'slug' => 'kamery']);
        $producent = Producent::create(['nazwa' => 'Sony']);

        $sprzet = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'Sony FX30',
            'numer_seryjny' => 'SN12345',
            'opis' => 'Profesjonalna kamera do filmów',
            'cena_doba' => 500.00,
            'kaucja' => 5000.00,
            'wartosc_rynkowa' => 25000.00,
            'status_sprzetu' => 'dostepny',
        ]);

        $this->assertDatabaseHas('sprzet', [
            'nazwa' => 'Sony FX30',
            'numer_seryjny' => 'SN12345',
            'cena_doba' => 500.00,
        ]);

        $this->assertEquals('Sony FX30', $sprzet->nazwa);
        $this->assertEquals('dostepny', $sprzet->status_sprzetu);
    }

    /**
     * Test 2: Metoda czyDostepny() zwraca true dla dostępnego sprzętu
     */
    public function test_czydostepny_zwraca_true_dla_dostepnego_sprzetu()
    {
        $kategoria = Kategoria::create(['nazwa' => 'Kamery', 'slug' => 'kamery']);
        $producent = Producent::create(['nazwa' => 'Canon']);

        $sprzet = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'Canon R5',
            'numer_seryjny' => 'CN98765',
            'cena_doba' => 400.00,
            'kaucja' => 4000.00,
            'wartosc_rynkowa' => 20000.00,
            'status_sprzetu' => 'dostepny',
        ]);

        $this->assertTrue($sprzet->czyDostepny());
    }

    /**
     * Test 3: Metoda czyDostepny() zwraca false dla niedostępnego sprzętu
     */
    public function test_czydostepny_zwraca_false_dla_niedostepnego_sprzetu()
    {
        $kategoria = Kategoria::create(['nazwa' => 'Obiektywy', 'slug' => 'obiektywy']);
        $producent = Producent::create(['nazwa' => 'Nikon']);

        $sprzet = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'Nikon Z 24-70mm',
            'numer_seryjny' => 'NK54321',
            'cena_doba' => 150.00,
            'kaucja' => 1500.00,
            'wartosc_rynkowa' => 7500.00,
            'status_sprzetu' => 'w_serwisie',
        ]);

        $this->assertFalse($sprzet->czyDostepny());
    }

    /**
     * Test 4: Sprzęt ma prawidłowe relacje z kategoria i producentem
     */
    public function test_sprzet_ma_prawidlowe_relacje()
    {
        $kategoria = Kategoria::create(['nazwa' => 'Oświetlenie', 'slug' => 'oswietlenie']);
        $producent = Producent::create(['nazwa' => 'Neewer']);

        $sprzet = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'LED Panel 200W',
            'numer_seryjny' => 'NW11111',
            'cena_doba' => 100.00,
            'kaucja' => 1000.00,
            'wartosc_rynkowa' => 5000.00,
            'status_sprzetu' => 'dostepny',
        ]);

        $this->assertNotNull($sprzet->kategoria);
        $this->assertEquals('Oświetlenie', $sprzet->kategoria->nazwa);
        
        $this->assertNotNull($sprzet->producent);
        $this->assertEquals('Neewer', $sprzet->producent->nazwa);
    }

    /**
     * Test 5: Metoda getZdjecieUrl() zwraca prawidłowy URL zdjęcia
     */
    public function test_get_zdjecie_url_zwraca_prawidlowy_url()
    {
        $kategoria = Kategoria::create(['nazwa' => 'Kamery', 'slug' => 'kamery']);
        $producent = Producent::create(['nazwa' => 'Panasonic']);

        // Test 5a: Custom URL zdjęcia
        $sprzet_custom = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'Panasonic S1H',
            'numer_seryjny' => 'PA22222',
            'url_zdjecia' => 'https://example.com/moja-kamera.jpg',
            'cena_doba' => 600.00,
            'kaucja' => 6000.00,
            'wartosc_rynkowa' => 30000.00,
            'status_sprzetu' => 'dostepny',
        ]);

        $this->assertEquals('https://example.com/moja-kamera.jpg', $sprzet_custom->getZdjecieUrl());

        // Test 5b: Default URL na podstawie kategorii
        $sprzet_default = Sprzet::create([
            'kategoria_id' => $kategoria->id,
            'producent_id' => $producent->id,
            'nazwa' => 'Lumix GH6',
            'numer_seryjny' => 'PA33333',
            'url_zdjecia' => null,
            'cena_doba' => 350.00,
            'kaucja' => 3500.00,
            'wartosc_rynkowa' => 17500.00,
            'status_sprzetu' => 'dostepny',
        ]);

        // Powinno zwrócić URL dla kategorii "Kamery"
        $url = $sprzet_default->getZdjecieUrl();
        $this->assertStringContainsString('unsplash.com', $url);
        $this->assertStringContainsString('photo-1502920917128-1aa500764cbd', $url);
    }
}

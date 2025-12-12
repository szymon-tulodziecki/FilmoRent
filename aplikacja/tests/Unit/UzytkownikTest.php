<?php

namespace Tests\Unit;

use App\Models\Uzytkownik;
use App\Models\Rola;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UzytkownikTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_name_attribute_returns_full_name()
    {
        $user = new Uzytkownik([
            'imie' => 'Jan',
            'nazwisko' => 'Kowalski',
        ]);
        $this->assertEquals('Jan Kowalski', $user->name);
    }

    public function test_can_access_panel_only_for_admin_and_pracownik()
    {
        $adminRole = new Rola(['klucz' => 'admin']);
        $adminRole->id = 1;
        $pracownikRole = new Rola(['klucz' => 'pracownik']);
        $pracownikRole->id = 2;
        $klientRole = new Rola(['klucz' => 'klient']);
        $klientRole->id = 3;

        $admin = new Uzytkownik(['rola_id' => 1]);
        $admin->setRelation('rola', $adminRole);
        $this->assertTrue($admin->canAccessPanel(new \Filament\Panel()));

        $pracownik = new Uzytkownik(['rola_id' => 2]);
        $pracownik->setRelation('rola', $pracownikRole);
        $this->assertTrue($pracownik->canAccessPanel(new \Filament\Panel()));

        $klient = new Uzytkownik(['rola_id' => 3]);
        $klient->setRelation('rola', $klientRole);
        $this->assertFalse($klient->canAccessPanel(new \Filament\Panel()));
    }
}

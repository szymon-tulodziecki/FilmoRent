<?php

namespace Tests\Unit;

use App\Models\Rola;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolaTest extends TestCase
{
    use RefreshDatabase;

    public function test_rola_has_many_uzytkownicy()
    {
        $rola = new Rola(['nazwa' => 'Test', 'klucz' => 'test']);
        $rola->id = 1;
        $user = new \App\Models\Uzytkownik([
            'imie' => 'Anna',
            'nazwisko' => 'Nowak',
            'email' => 'anna@example.com',
            'haslo' => bcrypt('password'),
            'rola_id' => 1
        ]);
        $rola->setRelation('uzytkownicy', collect([$user]));
        $this->assertTrue($rola->uzytkownicy->contains($user));
    }
}

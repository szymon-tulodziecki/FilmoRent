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
        $rola = Rola::factory()->create();
        $user = $rola->uzytkownicy()->create([
            'imie' => 'Anna',
            'nazwisko' => 'Nowak',
            'email' => 'anna@example.com',
            'haslo' => bcrypt('password'),
        ]);
        $this->assertTrue($rola->uzytkownicy->contains($user));
    }
}

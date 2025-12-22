<?php

namespace App\Http\Controllers;

use App\Models\Sprzet;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function show($id)
    {
        $sprzet = Sprzet::with(['producent', 'kategoria'])->findOrFail($id);
        return view('front.sprzet.show', compact('sprzet'));
    }
}

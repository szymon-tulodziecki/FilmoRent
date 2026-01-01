<?php

namespace App\Http\Controllers;

use App\Models\Rola;
use App\Models\Uzytkownik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('logowanie');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = Uzytkownik::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->haslo)) {
            return back()->withErrors([
                'email' => 'Nieprawidłowy email lub hasło.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('success', 'Zalogowano pomyślnie.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Wylogowano.');
    }

    public function showRegisterForm()
    {
        return view('rejestracja');
    }

    public function register(Request $request)
    {
        // Uproszczona walidacja - tylko email i hasło
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:uzytkownicy,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $rolaKlient = Rola::where('klucz', 'klient')->first();

        $userData = [
            'rola_id' => $rolaKlient?->id,
            'email' => $data['email'],
            'haslo' => Hash::make($data['password']),
            'typ_klienta' => 'indywidualny', // Domyślnie indywidualny
            'status_klienta' => 'aktywny',
        ];

        $user = Uzytkownik::create($userData);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Konto utworzone pomyślnie! Uzupełnij swoje dane w ustawieniach.');
    }
}

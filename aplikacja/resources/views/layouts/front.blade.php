<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FilmoRent - Profesjonalna Wypożyczalnia Sprzętu' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    <a href="#main-content" 
       class="absolute top-0 left-0 bg-blue-700 text-white p-3 z-50 -translate-y-full focus:translate-y-0 transition-transform duration-300">
       Przejdź do głównej treści
    </a>

    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
        <nav class="container mx-auto px-4 h-16 flex items-center justify-between" aria-label="Główna nawigacja">
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-2xl font-bold text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-1">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <span>FilmoRent</span>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/koszyk') }}" class="relative p-2 text-gray-600 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">
                        <span class="sr-only">Koszyk</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </a>
                    
                    <div class="hidden md:flex items-center gap-2">
                        <span class="text-sm font-semibold">Witaj, {{ Auth::user()->imie }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:underline focus:outline-none focus:ring-2 focus:ring-red-500 rounded p-1">
                                Wyloguj
                            </button>
                        </form>
                    </div>
                @else
                    <a href="/login" class="text-sm font-semibold text-gray-700 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-1">Logowanie</a>
                    <a href="/register" class="ml-4 px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Rejestracja</a>
                @endauth
            </div>
        </nav>
    </header>

    <main id="main-content" class="flex-grow w-full">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 container mx-auto my-4" role="alert">
                <p class="font-bold">Sukces</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-300 py-8 mt-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4">FilmoRent</h3>
                <p class="text-sm">Najlepszy sprzęt filmowy w Twoim mieście.</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Kontakt</h3>
                <p class="text-sm">ul. Filmowa 15, Warszawa</p>
                <p class="text-sm">pomoc@filmorent.pl</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Dostępność</h3>
                <p class="text-sm">Serwis dostosowany do standardu WCAG 2.1 AA.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>

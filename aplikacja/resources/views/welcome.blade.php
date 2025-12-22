<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FilmoRent - Profesjonalna wypożyczalnia sprzętu filmowego</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .hero-bg { background: url('https://images.unsplash.com/photo-1533518463841-d62e1fc91373?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .btn-primary { background: #f59e0b; color: #000; transition: all 0.3s; }
        .btn-primary:hover { background: #d97706; transform: translateY(-2px); }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">

    <!-- Navigation -->
    <nav class="bg-slate-900/80 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="camera" class="w-8 h-8 text-amber-500"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="#sprzet" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Sprzęt</a>
                    <a href="/sklep" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Sklep</a>
                    <a href="/o-nas" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">O nas</a>
                    <a href="/koszyk" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Koszyk</a>
                    <a href="/logowanie" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Logowanie</a>
                    <a href="#kontakt" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Kontakt</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg relative">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="text-center">
                <span class="inline-block py-2 px-4 rounded-full bg-amber-500/20 border border-amber-500/50 text-amber-300 text-sm font-semibold mb-6">
                    ✨ Nowość: ARRI Alexa Mini LF dostępna!
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 text-white">
                    Twórz filmy<br>
                    <span class="text-amber-400">sprzętem klasy kinowej</span>
                </h1>
                <p class="text-xl text-slate-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Wypożyczalnia stworzona przez filmowców dla filmowców.
                    Transparentne ceny, ubezpieczenie w cenie i wsparcie techniczne 24/7.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#sprzet" class="btn-primary px-8 py-4 font-bold rounded-xl shadow-lg">
                        Przeglądaj sprzęt
                    </a>
                    <a href="#kontakt" class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl border border-slate-700 transition duration-300">
                        Skontaktuj się
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipment Section -->
    <section id="sprzet" class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-white">Dostępny sprzęt</h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Wybierz spośród naszej kolekcji profesjonalnego sprzętu filmowego
                </p>
            </div>

            <!-- Sortowanie -->
            <div class="flex justify-center mb-12">
                <div class="flex flex-wrap justify-center gap-4">
                    <button class="px-6 py-2 bg-amber-500 text-black font-semibold rounded-lg hover:bg-amber-600 transition">Najnowsze</button>
                    <button class="px-6 py-2 bg-slate-800 text-slate-300 font-semibold rounded-lg hover:bg-slate-700 transition">Cena rosnąco</button>
                    <button class="px-6 py-2 bg-slate-800 text-slate-300 font-semibold rounded-lg hover:bg-slate-700 transition">Cena malejąco</button>
                    @foreach($kategorie as $kat)
                    <button class="px-6 py-2 bg-slate-800 text-slate-300 font-semibold rounded-lg hover:bg-slate-700 transition">{{ $kat->nazwa }}</button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($sprzety as $item)
                <div class="group bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden card-hover hover:border-amber-500/50">
                    <div class="absolute top-4 left-4 z-20">
                        <span class="bg-black/60 backdrop-blur-md text-xs font-bold px-3 py-1.5 rounded-lg text-white border border-white/10">
                            {{ $item->kategoria->nazwa ?? 'Brak' }}
                        </span>
                    </div>
                    <div class="h-64 overflow-hidden relative bg-slate-800">
                        <img src="https://placehold.co/600x400/374151/white?text={{ urlencode($item->nazwa) }}"
                             alt="{{ $item->nazwa }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span class="px-6 py-2 bg-amber-500 text-black font-bold rounded-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                Zobacz szczegóły
                            </span>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-white group-hover:text-amber-400 transition-colors mb-2">
                            {{ $item->nazwa }}
                        </h3>
                        <p class="text-slate-400 mb-4 line-clamp-2">
                            {{ $item->opis ?? 'Profesjonalny sprzęt filmowy wysokiej jakości.' }}
                        </p>
                        <div class="flex items-center text-slate-500 mb-4">
                            <i data-lucide="building" class="w-4 h-4 mr-2"></i>
                            <span>{{ $item->producent->nazwa ?? 'Brak' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                            <div>
                                <span class="text-xs text-slate-500 uppercase tracking-wider">Cena za dobę</span>
                                <span class="text-2xl font-bold text-white">{{ $item->cena_wypozyczenia }} zł</span>
                            </div>
                            <button class="w-12 h-12 rounded-full bg-amber-500 hover:bg-amber-600 flex items-center justify-center text-black transition-all shadow-lg shadow-amber-500/30 active:scale-95">
                                <i data-lucide="plus" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Dlaczego warto wybrać FilmoRent?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="check-circle" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Najnowszy sprzęt</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Dostęp do najnowocześniejszego sprzętu filmowego od wiodących producentów świata.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="truck" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Szybka dostawa</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Dostarczamy sprzęt bezpośrednio do miejsca realizacji projektu w całym kraju.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="headphones" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Wsparcie techniczne</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Nasz zespół ekspertów jest zawsze gotowy do pomocy 24/7.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontakt" class="py-20 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Skontaktuj się z nami</h2>
            <p class="text-xl mb-12 text-slate-400">
                Masz pytania? Chcesz wypożyczyć sprzęt? Napisz do nas!
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-6 sm:space-y-0 sm:space-x-12">
                <div class="flex items-center text-slate-300">
                    <i data-lucide="phone" class="w-6 h-6 mr-3 text-amber-400"></i>
                    <span class="text-lg">+48 123 456 789</span>
                </div>
                <div class="flex items-center text-slate-300">
                    <i data-lucide="mail" class="w-6 h-6 mr-3 text-amber-400"></i>
                    <span class="text-lg">kontakt@filmorent.pl</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-400 mb-4 md:mb-0">&copy; 2025 FilmoRent. Wszystkie prawa zastrzeżone.</p>
                <div class="flex space-x-6">
                    <a href="#polityka" class="text-slate-400 hover:text-amber-500 transition duration-150 text-sm">Polityka Prywatności</a>
                    <a href="#kontakt" class="text-slate-400 hover:text-amber-500 transition duration-150 text-sm">Kontakt</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

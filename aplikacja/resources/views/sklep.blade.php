<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sklep - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
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
                    <a href="/" class="flex-shrink-0">
                        <i data-lucide="camera" class="w-8 h-8 text-amber-500"></i>
                    </a>
                </div>
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Strona główna</a>
                    <a href="/sklep" class="text-amber-500 border-b-2 border-amber-500 transition duration-150 text-sm font-medium">Sklep</a>
                    <a href="/o-nas" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">O nas</a>
                    <a href="/koszyk" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Koszyk</a>
                    <a href="/logowanie" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Logowanie</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="bg-slate-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Sklep</h1>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Przeglądaj i wynajmuj profesjonalny sprzęt filmowy
                </p>
            </div>
        </div>
    </section>

    <!-- Equipment Section -->
    <section class="py-12 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($sprzety as $item)
                <div class="group bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden card-hover hover:border-amber-500/50">
                    <div class="absolute top-4 left-4 z-20">
                        <span class="bg-black/60 backdrop-blur-md text-xs font-bold px-3 py-1.5 rounded-lg text-white border border-white/10">
                            {{ $item->kategoria->nazwa ?? 'Brak' }}
                        </span>
                    </div>
                    <div class="h-48 overflow-hidden relative bg-slate-800">
                        <img src="https://placehold.co/400x300/374151/white?text={{ urlencode($item->nazwa) }}"
                             alt="{{ $item->nazwa }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span class="px-4 py-2 bg-amber-500 text-black font-bold rounded-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 text-sm">
                                Zobacz szczegóły
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-white group-hover:text-amber-400 transition-colors mb-2 line-clamp-2">
                            {{ $item->nazwa }}
                        </h3>
                        <p class="text-slate-400 mb-3 line-clamp-2 text-sm">
                            {{ $item->opis ?? 'Profesjonalny sprzęt filmowy wysokiej jakości.' }}
                        </p>
                        <div class="flex items-center text-slate-500 mb-3 text-sm">
                            <i data-lucide="building" class="w-4 h-4 mr-2"></i>
                            <span>{{ $item->producent->nazwa ?? 'Brak' }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-800">
                            <div>
                                <span class="text-xs text-slate-500 uppercase tracking-wider">Cena za dobę</span>
                                <span class="text-xl font-bold text-white">{{ $item->cena_wypozyczenia }} zł</span>
                            </div>
                            <button class="w-10 h-10 rounded-full bg-amber-500 hover:bg-amber-600 flex items-center justify-center text-black transition-all shadow-lg shadow-amber-500/30 active:scale-95">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-400 mb-4 md:mb-0">&copy; 2025 FilmoRent. Wszystkie prawa zastrzeżone.</p>
                <div class="flex space-x-6">
                    <a href="/o-nas" class="text-slate-400 hover:text-amber-500 transition duration-150 text-sm">O nas</a>
                    <a href="/kontakt" class="text-slate-400 hover:text-amber-500 transition duration-150 text-sm">Kontakt</a>
                    <a href="/polityka" class="text-slate-400 hover:text-amber-500 transition duration-150 text-sm">Polityka Prywatności</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
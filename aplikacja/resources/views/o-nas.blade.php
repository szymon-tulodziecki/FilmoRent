<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>O nas - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .hero-bg { background: url('https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat; }
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
                    <a href="/sklep" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Sklep</a>
                    <a href="/o-nas" class="text-amber-500 border-b-2 border-amber-500 transition duration-150 text-sm font-medium">O nas</a>
                    <a href="/koszyk" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Koszyk</a>
                    <a href="/logowanie" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Logowanie</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg relative">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 text-white">
                    O FilmoRent
                </h1>
                <p class="text-xl text-slate-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Tworzymy przez filmowców dla filmowców. Nasza misja to demokratyzacja dostępu do profesjonalnego sprzętu filmowego.
                </p>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-bold text-white mb-6">Nasza historia</h2>
                    <div class="space-y-6 text-slate-300 leading-relaxed">
                        <p>
                            FilmoRent powstał z pasji do kina i frustracji z ograniczonym dostępem do profesjonalnego sprzętu filmowego.
                            Założyciele - doświadczeni operatorzy i producenci - zauważyli lukę na rynku między drogimi zakupami a niewystarczającą jakością wypożyczalni.
                        </p>
                        <p>
                            W 2020 roku, podczas pandemii COVID-19, kiedy branża filmowa stanęła w miejscu, postanowiliśmy działać.
                            Zaczęliśmy od małego warsztatu w garażu, wyposażonego w kilka kamer i świateł. Pierwsi klienci byli znajomymi z branży.
                        </p>
                        <p>
                            Dziś, po 5 latach, jesteśmy liderem w branży wypożyczania sprzętu filmowego w Polsce.
                            Nasza flota obejmuje ponad 500 sztuk profesjonalnego sprzętu od wiodących światowych producentów.
                        </p>
                    </div>
                </div>
                <div class="bg-slate-900 rounded-2xl p-8 border border-slate-800">
                    <div class="grid grid-cols-2 gap-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold text-amber-400 mb-2">500+</div>
                            <div class="text-slate-400">Sztuk sprzętu</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-amber-400 mb-2">1000+</div>
                            <div class="text-slate-400">Zadowolonych klientów</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-amber-400 mb-2">50+</div>
                            <div class="text-slate-400">Filmów wyprodukowanych</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold text-amber-400 mb-2">24/7</div>
                            <div class="text-slate-400">Wsparcie techniczne</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-20 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Nasza misja</h2>
                <p class="text-xl text-slate-400 max-w-3xl mx-auto">
                    Wierzymy, że każdy filmowiec zasługuje na dostęp do narzędzi klasy światowej
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="users" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Dla każdego filmowca</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Niezależnie od budżetu czy doświadczenia. Każdy pomysł zasługuje na profesjonalne wykonanie.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="shield" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Najwyższa jakość</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Tylko sprawdzony, serwisowany sprzęt od renomowanych producentów. Gwarancja niezawodności.
                    </p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-500/20 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="heart" class="w-10 h-10 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-4">Pasja do kina</h3>
                    <p class="text-slate-400 leading-relaxed">
                        Kochamy to co robimy. Każdego dnia pomagamy w tworzeniu historii, które zmieniają świat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Nasz zespół</h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Doświadczeni profesjonaliści z wieloletnim stażem w branży filmowej
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-900 rounded-xl p-8 text-center border border-slate-800">
                    <div class="bg-slate-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="user" class="w-12 h-12 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Marek Kowalski</h3>
                    <p class="text-amber-400 mb-4">Założyciel & CEO</p>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Były operator kamery w Hollywood. 15 lat doświadczenia w produkcji filmowej.
                    </p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 text-center border border-slate-800">
                    <div class="bg-slate-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="user" class="w-12 h-12 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Anna Nowak</h3>
                    <p class="text-amber-400 mb-4">Dyrektor Techniczny</p>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Ekspert w zakresie sprzętu filmowego. Certyfikowany technik Sony i Panasonic.
                    </p>
                </div>
                <div class="bg-slate-900 rounded-xl p-8 text-center border border-slate-800">
                    <div class="bg-slate-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="user" class="w-12 h-12 text-amber-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Piotr Wiśniewski</h3>
                    <p class="text-amber-400 mb-4">Manager ds. Klientów</p>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Zawsze gotowy do pomocy. Zna każdy sprzęt w naszej kolekcji jak własną kieszeń.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-slate-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Dołącz do naszej rodziny</h2>
            <p class="text-xl mb-8 text-slate-400">
                Razem tworzymy niesamowite historie. Dołącz do grona zadowolonych klientów FilmoRent.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/sklep" class="btn-primary px-8 py-4 font-bold rounded-xl shadow-lg">
                    Zobacz ofertę
                </a>
                <a href="/kontakt" class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl border border-slate-700 transition duration-300">
                    Skontaktuj się
                </a>
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
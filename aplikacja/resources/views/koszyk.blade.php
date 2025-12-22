<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Koszyk - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
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
                    <a href="/sklep" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Sklep</a>
                    <a href="/o-nas" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">O nas</a>
                    <a href="/koszyk" class="text-amber-500 border-b-2 border-amber-500 transition duration-150 text-sm font-medium">Koszyk</a>
                    <a href="/logowanie" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Logowanie</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="bg-slate-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Twój koszyk</h1>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Przejrzyj swoje zamówienie przed finalizacją
                </p>
            </div>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="py-12 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Empty Cart State -->
            <div class="text-center py-20">
                <div class="bg-slate-900 rounded-2xl border border-slate-800 p-12 max-w-md mx-auto">
                    <div class="bg-slate-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="shopping-cart" class="w-12 h-12 text-slate-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Twój koszyk jest pusty</h3>
                    <p class="text-slate-400 mb-8 leading-relaxed">
                        Nie masz jeszcze żadnych produktów w koszyku. Przejdź do sklepu i dodaj pierwszy sprzęt do wypożyczenia.
                    </p>
                    <a href="/sklep" class="btn-primary px-8 py-4 font-bold rounded-xl shadow-lg inline-flex items-center">
                        <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                        Przejdź do sklepu
                    </a>
                </div>
            </div>

            <!-- Cart Items (when not empty - this would be shown dynamically) -->
            <!--
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6">
                        <div class="flex items-center space-x-6">
                            <div class="w-24 h-24 bg-slate-800 rounded-lg overflow-hidden">
                                <img src="https://placehold.co/100x100/374151/white?text=Camera" alt="Product" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-white mb-2">Sony A7S III</h3>
                                <p class="text-slate-400 text-sm mb-2">Profesjonalna kamera filmowa 4K</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            <button class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <i data-lucide="minus" class="w-4 h-4"></i>
                                            </button>
                                            <span class="text-white font-semibold">1</span>
                                            <button class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-white transition">
                                                <i data-lucide="plus" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                        <span class="text-slate-500">dni</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-slate-500">150 zł/dzień</div>
                                        <div class="text-lg font-bold text-white">150 zł</div>
                                    </div>
                                </div>
                            </div>
                            <button class="text-slate-500 hover:text-red-400 transition">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Podsumowanie zamówienia</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-slate-400">
                                <span>Sprzęt (1 szt.)</span>
                                <span>150 zł</span>
                            </div>
                            <div class="flex justify-between text-slate-400">
                                <span>Ubezpieczenie</span>
                                <span>15 zł</span>
                            </div>
                            <div class="flex justify-between text-slate-400">
                                <span>Dostawa</span>
                                <span>0 zł</span>
                            </div>
                            <hr class="border-slate-800">
                            <div class="flex justify-between text-white font-bold text-lg">
                                <span>Razem</span>
                                <span>165 zł</span>
                            </div>
                        </div>
                        <button class="w-full btn-primary py-4 font-bold rounded-xl shadow-lg mt-6">
                            Przejdź do płatności
                        </button>
                        <p class="text-xs text-slate-500 text-center mt-4">
                            Bezpieczna płatność obsługiwana przez Stripe
                        </p>
                    </div>

                    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6">
                        <h4 class="text-sm font-semibold text-white mb-3">Informacje o wypożyczeniu</h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 text-green-400 mr-2"></i>
                                Ubezpieczenie w cenie
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 text-green-400 mr-2"></i>
                                Darmowa dostawa i odbiór
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 text-green-400 mr-2"></i>
                                Wsparcie techniczne 24/7
                            </li>
                            <li class="flex items-center">
                                <i data-lucide="check" class="w-4 h-4 text-green-400 mr-2"></i>
                                Możliwość przedłużenia
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            -->
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
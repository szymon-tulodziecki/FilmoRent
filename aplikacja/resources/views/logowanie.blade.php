<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .btn-primary { background: #f59e0b; color: #000; transition: all 0.3s; }
        .btn-primary:hover { background: #d97706; transform: translateY(-2px); }
        .login-bg { background: url('https://images.unsplash.com/photo-1489599735734-79b4d8c35b02?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat; }
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
                    <a href="/koszyk" class="text-slate-300 hover:text-amber-500 transition duration-150 text-sm font-medium">Koszyk</a>
                    <a href="/logowanie" class="text-amber-500 border-b-2 border-amber-500 transition duration-150 text-sm font-medium">Logowanie</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <i data-lucide="camera" class="w-16 h-16 text-amber-500"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Zaloguj się do FilmoRent</h2>
                <p class="text-slate-400">Dostęp do swojego konta i historii wypożyczeń</p>
            </div>

            <form class="mt-8 space-y-6" action="#" method="POST">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                            Adres email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                placeholder="twoj@email.com"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">
                            Hasło
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                class="block w-full pl-10 pr-10 py-3 border border-slate-700 rounded-lg bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                placeholder="••••••••"
                            >
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i data-lucide="eye" class="w-5 h-5 text-slate-500 hover:text-slate-400 transition"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-slate-700 rounded bg-slate-900"
                        >
                        <label for="remember-me" class="ml-2 block text-sm text-slate-300">
                            Zapamiętaj mnie
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="text-amber-400 hover:text-amber-300 transition">
                            Zapomniałeś hasła?
                        </a>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition"
                    >
                        Zaloguj się
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-slate-400">
                        Nie masz jeszcze konta?
                        <a href="#" class="text-amber-400 hover:text-amber-300 font-medium transition">
                            Zarejestruj się
                        </a>
                    </p>
                </div>
            </form>

            <!-- Social Login -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-slate-950 text-slate-500">lub kontynuuj z</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button
                        type="button"
                        class="w-full inline-flex justify-center py-2 px-4 border border-slate-700 rounded-lg bg-slate-900 text-sm font-medium text-slate-300 hover:bg-slate-800 transition"
                    >
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </button>

                    <button
                        type="button"
                        class="w-full inline-flex justify-center py-2 px-4 border border-slate-700 rounded-lg bg-slate-900 text-sm font-medium text-slate-300 hover:bg-slate-800 transition"
                    >
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </button>
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
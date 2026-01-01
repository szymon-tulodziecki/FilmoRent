<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rejestracja - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @include('components.styles')
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .btn-primary { background: #f59e0b; color: #000; transition: all 0.3s; }
        .btn-primary:hover { background: #d97706; transform: translateY(-2px); }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased">

    @include('components.navbar')

    <section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <i data-lucide="user-plus" class="w-16 h-16 text-amber-500"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Załóż konto w FilmoRent</h2>
                <p class="text-slate-400">Rezerwuj szybciej, śledź wypożyczenia i faktury</p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('rejestracja.store') }}" method="POST">
                @csrf
                @if($errors->any())
                    <div class="p-3 rounded-lg border border-red-500/60 bg-red-500/10 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Adres email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="mail" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                   class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                   placeholder="twoj@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Hasło</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                   class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Potwierdź hasło</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="w-5 h-5 text-slate-500"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                   class="block w-full pl-10 pr-3 py-3 border border-slate-700 rounded-lg bg-slate-900 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 text-sm font-medium rounded-lg btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition">
                        Załóż konto
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-slate-400">
                        Masz już konto?
                        <a href="{{ route('logowanie') }}" class="text-amber-400 hover:text-amber-300 font-medium transition">Zaloguj się</a>
                    </p>
                </div>
            </form>
        </div>
    </section>

    @include('components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>

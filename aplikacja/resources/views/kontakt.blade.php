<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kontakt - FilmoRent. Skontaktuj się z nami">
    <title>Kontakt - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @include('components.styles')
</head>
<body class="bg-slate-950 text-slate-100 antialiased">

    @include('components.navbar')

    <!-- Contact Section -->
    <section class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-5xl font-extrabold text-white mb-4">Kontakt</h1>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Masz pytania? Chętnie Ci pomożemy. Skontaktuj się z nami w dowolny sposób.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Phone -->
                <div class="bg-slate-900 rounded-2xl p-8 border border-slate-800 text-center">
                    <div class="bg-amber-500/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="phone" class="w-8 h-8 text-amber-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-white mb-2">Telefon</h2>
                    <p class="text-slate-400 mb-4">Dostępni od poniedziałku do piątku, 9:00 - 18:00</p>
                    <a href="tel:+48123456789" class="text-amber-400 font-semibold hover:text-amber-300">+48 123 456 789</a>
                </div>

                <!-- Email -->
                <div class="bg-slate-900 rounded-2xl p-8 border border-slate-800 text-center">
                    <div class="bg-amber-500/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="mail" class="w-8 h-8 text-amber-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-white mb-2">Email</h2>
                    <p class="text-slate-400 mb-4">Odpowiadamy w ciągu 24 godzin</p>
                    <a href="mailto:kontakt@filmorent.pl" class="text-amber-400 font-semibold hover:text-amber-300">kontakt@filmorent.pl</a>
                </div>

                <!-- Address -->
                <div class="bg-slate-900 rounded-2xl p-8 border border-slate-800 text-center">
                    <div class="bg-amber-500/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="map-pin" class="w-8 h-8 text-amber-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-white mb-2">Adres</h2>
                    <p class="text-slate-400">
                        ul. Filmowa 42<br>
                        00-001 Warszawa, Polska
                    </p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="max-w-2xl mx-auto bg-slate-900 rounded-2xl p-12 border border-slate-800">
                <h2 class="text-2xl font-bold text-white mb-8">Wyślij nam wiadomość</h2>
                
                @if(session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('kontakt.store') }}" class="space-y-6">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Imię i nazwisko</label>
                            <input type="text" name="imie_nazwisko" value="{{ old('imie_nazwisko') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" placeholder="Twoje imię i nazwisko" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-white mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" placeholder="twoj@email.com" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Temat</label>
                        <input type="text" name="temat" value="{{ old('temat') }}" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" placeholder="Temat wiadomości" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-white mb-2">Wiadomość</label>
                        <textarea name="wiadomosc" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500" rows="6" placeholder="Wpisz swoją wiadomość..." required>{{ old('wiadomosc') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-black font-bold py-3 rounded-lg transition duration-300 shadow-lg shadow-amber-500/20 focus:outline-none">
                        Wyślij wiadomość
                    </button>
                </form>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

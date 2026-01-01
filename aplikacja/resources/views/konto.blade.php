<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konto klienta - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @include('components.styles')
</head>
<body class="bg-slate-950 text-slate-100 antialiased font-['Manrope']">
    @include('components.navbar')

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Komunikaty -->
            @if($message = session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500 rounded-lg text-green-400 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    {{ $message }}
                </div>
            @endif
            @if($message = session('error'))
                <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-lg text-red-400 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    {{ $message }}
                </div>
            @endif

            <!-- Nagłówek -->
            <div class="mb-10">
                <p class="text-sm uppercase tracking-[0.15em] text-amber-400 font-bold mb-1">Panel klienta</p>
                <h1 class="text-3xl font-black text-white">Cześć, {{ $user->imie ?? 'użytkowniku' }}!</h1>
                <p class="text-slate-400">{{ $user->email }}</p>
            </div>

            <!-- Zakładki -->
            <div class="flex gap-2 mb-8 border-b border-slate-700">
                <button onclick="switchTab('aktywne')" id="tab-aktywne" class="px-6 py-3 font-semibold border-b-2 border-amber-500 text-amber-400 transition flex items-center gap-2">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    Aktualne zamówienia
                </button>
                <button onclick="switchTab('historia')" id="tab-historia" class="px-6 py-3 font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-300 transition flex items-center gap-2">
                    <i data-lucide="history" class="w-4 h-4"></i>
                    Historia zamówień
                </button>
                <button onclick="switchTab('ustawienia')" id="tab-ustawienia" class="px-6 py-3 font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-300 transition flex items-center gap-2">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    Ustawienia
                </button>
            </div>

            <!-- TAB 1: AKTUALNE ZAMÓWIENIA -->
            <section id="content-aktywne" class="space-y-4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Aktualne zamówienia</h2>
                    <span class="text-sm bg-amber-500/20 text-amber-400 px-4 py-2 rounded-full font-semibold">{{ $aktywne->count() }} zamówienia</span>
                </div>

                @forelse($aktywne as $zamowienie)
                    <div class="bg-slate-900/90 border border-slate-600 rounded-2xl p-6 shadow-xl hover:border-slate-500 transition">
                        <div class="grid sm:grid-cols-12 gap-6 mb-6">
                            <!-- Dane zamówienia -->
                            <div class="sm:col-span-6 space-y-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.12em] text-slate-400 mb-1">Numer zamówienia</p>
                                    <p class="text-xl font-bold text-white">{{ $zamowienie->numer_zamowienia }}</p>
                                </div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-800/80 rounded-full border border-slate-600">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $zamowienie->status->kolor }}; opacity: 0.8;"></span>
                                    <span class="text-sm font-semibold">{{ $zamowienie->status->nazwa }}</span>
                                </div>
                            </div>

                            <!-- Daty i suma -->
                            <div class="sm:col-span-6 space-y-3">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl p-3">
                                        <p class="text-xs text-slate-400 mb-1">Odbiór</p>
                                        <p class="font-semibold text-white">{{ optional($zamowienie->data_odbioru)->format('d.m.Y') }}</p>
                                    </div>
                                    <div class="bg-slate-800/80 border border-slate-600 rounded-xl p-3">
                                        <p class="text-xs text-slate-400 mb-1">Zwrot</p>
                                        <p class="font-semibold text-white">{{ optional($zamowienie->data_zwrotu)->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sprzęt -->
                        <div class="mb-6 pb-6 border-b border-slate-700">
                            <p class="text-sm font-semibold text-slate-300 mb-3">Sprzęt w zamówieniu:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($zamowienie->sprzety as $sprzet)
                                    <span class="px-4 py-2 rounded-full bg-slate-800/80 border border-slate-600 text-sm text-slate-100 flex items-center gap-2">
                                        <i data-lucide="camera" class="w-3 h-3"></i>
                                        {{ $sprzet->nazwa }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Suma -->
                        <div class="mb-6 pb-6 border-b border-slate-700">
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-1">Kwota do zapłaty</p>
                                <p class="text-3xl font-black text-amber-400">{{ number_format($zamowienie->suma_calkowita ?? 0, 0, ',', ' ') }} zł</p>
                            </div>
                        </div>

                        <!-- Akcje -->
                        <div class="space-y-3">
                            @if($zamowienie->status->klucz === 'wRealizacji')
                                <form action="{{ route('konto.anuluj', $zamowienie->id) }}" method="POST" onsubmit="return confirm('Czy na pewno? Będziesz mógł anulować tylko teraz, zanim status zmieni się na &quot;Wysyłka&quot;.');">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="w-full px-4 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold rounded-lg transition flex items-center justify-center gap-2">
                                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        Anuluj zamówienie
                                    </button>
                                </form>
                                <p class="text-xs text-slate-400 text-center">⚠️ Możesz anulować tylko w statusie "W realizacji"</p>
                            @elseif($zamowienie->status->klucz === 'wydane')
                                <form action="{{ route('konto.przedluz', $zamowienie->id) }}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="w-full px-4 py-3 bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 font-semibold rounded-lg transition flex items-center justify-center gap-2">
                                        <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                                        Przedłuż o 7 dni
                                    </button>
                                </form>
                            @else
                                <div class="px-4 py-3 bg-slate-800/50 text-slate-400 font-semibold rounded-lg text-center">
                                    <p class="text-sm">Status: {{ $zamowienie->status->nazwa }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Anulowanie niemożliwe na tym etapie</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-12 text-center">
                        <i data-lucide="package-x" class="w-12 h-12 text-slate-400 mx-auto mb-4 opacity-50"></i>
                        <p class="text-slate-300 text-lg font-semibold mb-2">Brak aktywnych zamówień</p>
                        <p class="text-slate-400 mb-6">Przejdź do sklepu i złóż nowe zamówienie</p>
                        <a href="{{ route('sklep') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-lg transition">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            Przejdź do sklepu
                        </a>
                    </div>
                @endforelse
            </section>

            <!-- TAB 2: HISTORIA ZAMÓWIEŃ -->
            <section id="content-historia" class="space-y-4 hidden">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-white">Historia zamówień</h2>
                    <span class="text-sm bg-slate-700 text-slate-300 px-4 py-2 rounded-full font-semibold">{{ $archiwum->count() }} zamówień</span>
                </div>

                @forelse($archiwum as $zamowienie)
                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-5 hover:border-slate-500 transition">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-white mb-1">{{ $zamowienie->numer_zamowienia }}</p>
                                <div class="flex items-center gap-3 text-xs">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-800/80 rounded" style="color: {{ $zamowienie->status->kolor }};">
                                        ● {{ $zamowienie->status->nazwa }}
                                    </span>
                                    <span class="text-slate-400">{{ optional($zamowienie->data_zwrotu ?? $zamowienie->utworzono_data)->format('d.m.Y') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-1">Kwota</p>
                                <p class="font-bold text-amber-400">{{ number_format($zamowienie->suma_calkowita ?? 0, 0, ',', ' ') }} zł</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-12 text-center">
                        <i data-lucide="history" class="w-12 h-12 text-slate-400 mx-auto mb-4 opacity-50"></i>
                        <p class="text-slate-300 text-lg font-semibold">Brak historii zamówień</p>
                        <p class="text-slate-400">Twoje zrealizowane zamówienia pojawią się tutaj</p>
                    </div>
                @endforelse
            </section>

            <!-- TAB 3: USTAWIENIA -->
            <section id="content-ustawienia" class="space-y-4 hidden">
                <h2 class="text-2xl font-bold text-white mb-6">Ustawienia konta</h2>
                
                <!-- DANE OSOBOWE / BIZNESOWE - FORMULARZ EDYCJI -->
                <div class="bg-slate-900/90 border border-slate-600 rounded-2xl p-6">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-amber-400"></i>
                        Dane {{ $user->typ_klienta === 'biznesowy' ? 'biznesowe' : 'osobowe' }}
                    </h3>
                    
                    <form action="{{ route('konto.update') }}" method="POST" class="space-y-6">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @method('PUT')
                        
                        <!-- EMAIL (ZAWSZE WIDOCZNE) -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">Email</label>
                            <input type="email" id="email" value="{{ $user->email }}" 
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white cursor-not-allowed opacity-75"
                                disabled>
                            <p class="text-xs text-slate-500 mt-1">Email nie może być zmieniony</p>
                        </div>
                        
                        <!-- TYP KLIENTA - NAJWAŻNIEJSZY WYBÓR -->
                        <div>
                            <label for="typ_klienta" class="block text-sm font-semibold text-slate-300 mb-2">Typ klienta *</label>
                            <select id="typ_klienta" name="typ_klienta" onchange="toggleClientType()" 
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white focus:outline-none focus:border-amber-500 transition"
                                required>
                                                                <option value="">Wybierz typ klienta</option>
                                <option value="indywidualny" {{ $user->typ_klienta === 'indywidualny' ? 'selected' : '' }}>Klient indywidualny</option>
                                <option value="biznesowy" {{ $user->typ_klienta === 'biznesowy' ? 'selected' : '' }}>Klient biznesowy</option>
                            </select>
                            @error('typ_klienta')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IMIĘ I NAZWISKO (wspólne) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="imie" class="block text-sm font-semibold text-slate-300 mb-2">Imię *</label>
                                <input type="text" id="imie" name="imie" value="{{ $user->imie }}" 
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                    required>
                                @error('imie')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="nazwisko" class="block text-sm font-semibold text-slate-300 mb-2">Nazwisko *</label>
                                <input type="text" id="nazwisko" name="nazwisko" value="{{ $user->nazwisko }}" 
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                    required>
                                @error('nazwisko')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- DANE INDYWIDUALNEGO -->
                        <div id="indywidualny-section" class="space-y-4 border-t border-slate-600 pt-6">
                            <h4 class="text-sm font-semibold text-amber-400 uppercase tracking-wider">Dane osobowe</h4>
                            <div>
                                <label for="pesel" class="block text-sm font-semibold text-slate-300 mb-2">PESEL</label>
                                <input type="text" id="pesel" name="pesel" value="{{ $user->pesel }}" 
                                    maxlength="11"
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                    placeholder="11 cyfr">
                                @error('pesel')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- DANE BIZNESOWE -->
                        <div id="biznesowy-section" class="space-y-4 border-t border-slate-600 pt-6 hidden">
                            <h4 class="text-sm font-semibold text-amber-400 uppercase tracking-wider">Dane firmy</h4>
                            <div>
                                <label for="nazwa_firmy" class="block text-sm font-semibold text-slate-300 mb-2">Nazwa firmy *</label>
                                <input type="text" id="nazwa_firmy" name="nazwa_firmy" value="{{ $user->nazwa_firmy }}" 
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                    data-required-biz="true">
                                @error('nazwa_firmy')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="nip" class="block text-sm font-semibold text-slate-300 mb-2">NIP *</label>
                                    <input type="text" id="nip" name="nip" value="{{ $user->nip }}" 
                                        maxlength="10"
                                        class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                        placeholder="10 cyfr"
                                        data-required-biz="true">
                                    @error('nip')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="regon" class="block text-sm font-semibold text-slate-300 mb-2">REGON</label>
                                    <input type="text" id="regon" name="regon" value="{{ $user->regon }}" 
                                        class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition"
                                        placeholder="REGON">
                                    @error('regon')
                                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="osoba_kontaktowa" class="block text-sm font-semibold text-slate-300 mb-2">Osoba kontaktowa</label>
                                <input type="text" id="osoba_kontaktowa" name="osoba_kontaktowa" value="{{ $user->osoba_kontaktowa }}" 
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition">
                                @error('osoba_kontaktowa')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="stanowisko" class="block text-sm font-semibold text-slate-300 mb-2">Stanowisko</label>
                                <input type="text" id="stanowisko" name="stanowisko" value="{{ $user->stanowisko }}" 
                                    class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition">
                                @error('stanowisko')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- TELEFON (ZAWSZE WIDOCZNE) -->
                        <div class="border-t border-slate-600 pt-6">
                            <label for="telefon" class="block text-sm font-semibold text-slate-300 mb-2">Telefon</label>
                            <input type="tel" id="telefon" name="telefon" value="{{ $user->telefon }}" 
                                class="w-full px-4 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 transition">
                            @error('telefon')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- PRZYCISK ZAPISANIA -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-lg transition flex items-center justify-center gap-2">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                Zapisz zmiany
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- STATUS I NOTATKI CRM -->
                <div class="bg-slate-900/90 border border-slate-600 rounded-2xl p-6">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
                        Status konta
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-slate-400 mb-1">Status</p>
                            <div>
                                @php
                                    $statusColors = [
                                        'aktywny' => 'bg-green-500/20 text-green-400',
                                        'wstrzymany' => 'bg-yellow-500/20 text-yellow-400',
                                        'zablokowany' => 'bg-red-500/20 text-red-400',
                                    ];
                                    $statusNames = [
                                        'aktywny' => 'Aktywny',
                                        'wstrzymany' => 'Wstrzymany',
                                        'zablokowany' => 'Zablokowany',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded font-semibold text-sm {{ $statusColors[$user->status_klienta] ?? 'bg-slate-700 text-slate-300' }}">
                                    {{ $statusNames[$user->status_klienta] ?? ucfirst($user->status_klienta) }}
                                </span>
                            </div>
                        </div>
                        
                        @if($user->notatki_crm)
                            <div>
                                <p class="text-sm text-slate-400 mb-1">Notatki</p>
                                <p class="text-white text-sm">{{ $user->notatki_crm }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- WYLOGOWANIE -->
                <div class="bg-slate-900/90 border border-slate-600 rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-white font-semibold mb-1">Wyloguj się</h3>
                            <p class="text-slate-400 text-sm">Bezpieczne wylogowanie z konta</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="px-6 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 font-semibold rounded-lg transition">
                                Wyloguj
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @include('components.footer')

    <script>
        function switchTab(tabName) {
            // Ukryj wszystkie sekcje
            document.getElementById('content-aktywne').classList.add('hidden');
            document.getElementById('content-historia').classList.add('hidden');
            document.getElementById('content-ustawienia').classList.add('hidden');

            // Usuń aktywność wszystkich przycisków
            document.getElementById('tab-aktywne').classList.remove('border-amber-500', 'text-amber-400');
            document.getElementById('tab-historia').classList.remove('border-amber-500', 'text-amber-400');
            document.getElementById('tab-ustawienia').classList.remove('border-amber-500', 'text-amber-400');

            document.getElementById('tab-aktywne').classList.add('border-transparent', 'text-slate-400');
            document.getElementById('tab-historia').classList.add('border-transparent', 'text-slate-400');
            document.getElementById('tab-ustawienia').classList.add('border-transparent', 'text-slate-400');

            // Pokaż wybraną sekcję i zaznacz przycisk
            document.getElementById(`content-${tabName}`).classList.remove('hidden');
            document.getElementById(`tab-${tabName}`).classList.remove('border-transparent', 'text-slate-400');
            document.getElementById(`tab-${tabName}`).classList.add('border-amber-500', 'text-amber-400');
        }

        function toggleClientType() {
            const typ = document.getElementById('typ_klienta').value;
            const indySection = document.getElementById('indywidualny-section');
            const bizSection = document.getElementById('biznesowy-section');
            const bizRequired = bizSection.querySelectorAll('[data-required-biz="true"]');
            
            if (typ === 'indywidualny') {
                indySection.classList.remove('hidden');
                bizSection.classList.add('hidden');
                bizRequired.forEach(input => {
                    input.required = false;
                    input.disabled = true;
                });
            } else {
                indySection.classList.add('hidden');
                bizSection.classList.remove('hidden');
                bizRequired.forEach(input => {
                    input.required = true;
                    input.disabled = false;
                });
            }
        }

        // Inicjalizuj ikony i toggle na załadowaniu
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
            // Ukryj odpowiednią sekcję na start
            toggleClientType();
            // Otwórz od razu zakładkę ustawienia, żeby typ klienta był widoczny
            switchTab('ustawienia');
        });
    </script>
</body>
</html>

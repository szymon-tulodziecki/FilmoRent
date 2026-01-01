<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sprzet->nazwa }} - FilmoRent</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/pl.js"></script>

    <x-styles />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: { 850: '#151e2e', 925: '#0f172a' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-['Manrope'] antialiased">
    <x-navbar />

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="mb-8 text-sm font-medium">
                <ol class="flex items-center flex-wrap gap-2 text-slate-400">
                    <li><a href="{{ route('sklep') }}" class="hover:text-amber-400 transition">Sklep</a></li>
                    <li><span class="text-slate-600">/</span></li>
                    <li><a href="{{ route('sklep', ['kategoria' => $sprzet->kategoria->slug]) }}" class="hover:text-amber-400 transition">{{ $sprzet->kategoria->nazwa }}</a></li>
                    <li><span class="text-slate-600">/</span></li>
                    <li class="text-amber-500 truncate max-w-[200px]">{{ $sprzet->nazwa }}</li>
                </ol>
            </nav>

            @if(session('success') || session('error') || $errors->any())
                <div class="mb-8 space-y-4">
                    @if(session('success'))
                        <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-lg text-green-400 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12 mb-20">
                
                <div class="lg:col-span-7 space-y-8">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-slate-900/90 border border-slate-600 relative group">
                        <img src="{{ $sprzet->getZdjecieUrl() }}" alt="{{ $sprzet->nazwa }}" class="w-full h-full object-contain p-8 group-hover:scale-105 transition duration-500 ease-out">
                        
                        <div class="absolute top-4 left-4">
                            @if($sprzet->status_sprzetu === 'dostepny')
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 border border-green-500/30 rounded-full text-xs font-bold uppercase tracking-wide backdrop-blur-md">
                                    Dostępny
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-500/20 text-slate-400 border border-slate-500/30 rounded-full text-xs font-bold uppercase tracking-wide backdrop-blur-md">
                                    Niedostępny
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                            Dane techniczne
                        </h3>
                        <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                            <div class="flex justify-between py-3 border-b border-slate-800">
                                <span class="text-slate-400">Producent</span>
                                <span class="text-white font-medium">{{ $sprzet->producent->nazwa }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-slate-800">
                                <span class="text-slate-400">Kategoria</span>
                                <span class="text-white font-medium">{{ $sprzet->kategoria->nazwa }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-slate-800">
                                <span class="text-slate-400">Numer seryjny</span>
                                <span class="text-white font-mono">{{ $sprzet->numer_seryjny }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-slate-800">
                                <span class="text-slate-400">Wartość rynkowa</span>
                                <span class="text-white font-medium">{{ number_format($sprzet->wartosc_rynkowa, 0, ',', ' ') }} zł</span>
                            </div>
                        </div>
                        
                        @if($sprzet->opis)
                            <div class="mt-8 pt-6 border-t border-slate-800">
                                <h4 class="text-sm font-bold text-slate-300 mb-3 uppercase tracking-wide">Opis produktu</h4>
                                <p class="text-slate-400 leading-relaxed">{{ $sprzet->opis }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-5" x-data="rezerwacja({{ $sprzet->cena_doba }})">
                    <div class="sticky top-24 space-y-6">
                        
                        <div>
                            <p class="text-amber-500 font-bold text-sm tracking-wider uppercase mb-2">{{ $sprzet->kategoria->nazwa }}</p>
                            <h1 class="text-3xl sm:text-4xl font-black text-white leading-tight mb-2">{{ $sprzet->nazwa }}</h1>
                            <p class="text-slate-400">Model referencyjny od {{ $sprzet->producent->nazwa }}</p>
                        </div>

                        <div class="p-6 bg-gradient-to-br from-slate-900/90 to-slate-900/70 border border-slate-600 rounded-2xl shadow-xl">
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-4xl font-black text-white">{{ number_format($sprzet->cena_doba, 0, ',', ' ') }} zł</span>
                                <span class="text-slate-400">/ dzień</span>
                            </div>
                            <div class="text-sm text-slate-500 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                Kaucja zwrotna: <span class="text-slate-300 font-medium">{{ number_format($sprzet->kaucja, 0, ',', ' ') }} zł</span>
                            </div>

                            <div class="my-6 h-px bg-slate-800"></div>

                            @if($sprzet->status_sprzetu === 'dostepny')
                                <form action="{{ route('koszyk.dodaj') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="sprzet_id" value="{{ $sprzet->id }}">
                                    <input type="hidden" name="data_od" x-model="startFormatted">
                                    <input type="hidden" name="data_do" x-model="endFormatted">

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Wybierz termin</label>
                                            <div class="relative">
                                                <input x-ref="datepicker" type="text" 
                                                    class="w-full bg-slate-950 border border-slate-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none cursor-pointer font-medium" 
                                                    placeholder="Wybierz zakres dat..." readonly>
                                                <div class="absolute right-4 top-3.5 text-slate-500 pointer-events-none">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="days > 0" x-transition class="bg-slate-950/70 rounded-xl p-4 border border-slate-700 space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-slate-400">Liczba dni</span>
                                                <span class="text-white font-bold" x-text="days"></span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-slate-400">Cena za dobę</span>
                                                <span class="text-white">{{ number_format($sprzet->cena_doba, 0, ',', ' ') }} zł</span>
                                            </div>
                                            <div class="pt-2 mt-2 border-t border-slate-800 flex justify-between items-center">
                                                <span class="text-slate-300 font-bold">Suma</span>
                                                <span class="text-amber-500 text-xl font-black" x-text="totalCost + ' zł'"></span>
                                            </div>
                                        </div>

                                        <button type="submit" 
                                            :disabled="days === 0"
                                            :class="days > 0 ? 'bg-amber-500 hover:bg-amber-400 text-slate-900' : 'bg-slate-800 text-slate-500 cursor-not-allowed'"
                                            class="w-full py-4 rounded-xl font-bold transition-all duration-200 shadow-lg flex items-center justify-center gap-2 group">
                                            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                            <span x-text="days > 0 ? 'Dodaj do rezerwacji' : 'Wybierz daty'"></span>
                                        </button>
                                        
                                        <p class="text-xs text-center text-slate-500 mt-2">
                                            Nie pobieramy opłaty w momencie rezerwacji.
                                        </p>
                                    </div>
                                </form>
                            @else
                                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 text-center">
                                    <p class="text-red-400 font-bold mb-1">Produkt niedostępny</p>
                                    <p class="text-xs text-red-400/70">Ten sprzęt jest obecnie w serwisie lub wypożyczony.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($podobne->count() > 0)
                <div class="border-t border-slate-700 pt-16">
                    <h2 class="text-2xl font-bold text-white mb-8">Może Cię zainteresować</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($podobne as $produkt)
                            <a href="{{ route('produkt.show', $produkt) }}" class="group block bg-slate-900/90 rounded-xl overflow-hidden hover:ring-2 hover:ring-amber-500 transition duration-300 border border-slate-600">
                                <div class="aspect-square bg-slate-800/90 relative overflow-hidden">
                                    <img src="{{ $produkt->getZdjecieUrl() }}" alt="{{ $produkt->nazwa }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <div class="p-4">
                                    <p class="text-amber-500 text-xs font-bold uppercase mb-1">{{ $produkt->kategoria->nazwa }}</p>
                                    <h3 class="text-white font-bold text-sm mb-2 line-clamp-2 group-hover:text-amber-400 transition">{{ $produkt->nazwa }}</h3>
                                    <p class="text-slate-300 font-bold">{{ number_format($produkt->cena_doba, 0, ',', ' ') }} zł</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rezerwacja', (pricePerDay) => ({
                days: 0,
                startFormatted: '', // data dla backendu Y-m-d
                endFormatted: '',   // data dla backendu Y-m-d
                
                init() {
                    // Inicjalizacja Flatpickr
                    flatpickr(this.$refs.datepicker, {
                        mode: "range",
                        minDate: "today",
                        dateFormat: "d.m.Y", // format dla użytkownika
                        locale: "pl",
                        theme: "dark",
                        onChange: (selectedDates, dateStr, instance) => {
                            if (selectedDates.length === 2) {
                                const start = selectedDates[0];
                                const end = selectedDates[1];
                                
                                // Obliczanie różnicy dni
                                const diffTime = Math.abs(end - start);
                                // +1 bo liczymy dni włącznie (jeśli wypożyczasz pn-wt to płacisz za 2 dni)
                                this.days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 

                                // Formatowanie dat dla inputów hidden (format SQL)
                                this.startFormatted = instance.formatDate(start, "Y-m-d");
                                this.endFormatted = instance.formatDate(end, "Y-m-d");
                            } else {
                                this.days = 0;
                                this.startFormatted = '';
                                this.endFormatted = '';
                            }
                        }
                    });
                },

                get totalCost() {
                    return (this.days * pricePerDay).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                }
            }));
        });
    </script>
</body>
</html>
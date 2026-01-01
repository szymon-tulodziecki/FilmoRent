<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FilmoRent - Profesjonalna wypożyczalnia sprzętu filmowego i fotograficznego. Bez ukrytych kosztów, z pełnym supportem technicznym na planie.">
    <title>FilmoRent - Profesjonalna wypożyczalnia sprzętu filmowego</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @include('components.styles')
    <style>
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        a:focus, button:focus, input:focus, textarea:focus, select:focus {
            outline: none;
        }
        
        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible {
            outline: 2px solid #f59e0b;
            outline-offset: 2px;
        }

        .skip-link {
            position: absolute;
            top: 0;
            left: 0;
            background: #f59e0b;
            color: #000;
            padding: 0.75rem 1rem;
            z-index: 50;
            transform: translateY(-100%);
            transition: transform 0.3s;
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        body.high-contrast {
            background-color: #000 !important;
            color: #fff !important;
        }

        body.high-contrast * {
            background-color: #000 !important;
            color: #fff !important;
            border-color: #fff !important;
        }

        body.high-contrast a {
            color: #ffff00 !important;
            text-decoration: underline !important;
        }

        body.high-contrast button {
            border: 2px solid #fff !important;
            background-color: #000 !important;
            color: #fff !important;
        }

        body.dyslexia-font {
            font-family: 'Comic Sans MS', 'OpenDyslexic', cursive !important;
            letter-spacing: 0.1em !important;
            line-height: 1.8 !important;
        }

        body.dyslexia-font * {
            font-family: 'Comic Sans MS', 'OpenDyslexic', cursive !important;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-amber-500 selection:text-black">
    <a href="#main-content" class="skip-link">Przejdź do głównej treści</a>

    @include('components.navbar')

    <section class="relative min-h-[70vh] md:h-[85vh] flex items-center overflow-hidden py-12 md:py-0" id="main-content">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1533518463841-d62e1fc91373?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center hero-animate opacity-60" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent" aria-hidden="true"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-transparent to-transparent" aria-hidden="true"></div>
        </div>
        
        <div class="ambient-glow top-[-20%] left-[-10%] bg-amber-600/20" aria-hidden="true"></div>
        <div class="ambient-glow bottom-[-20%] right-[-10%] bg-blue-600/10" aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8 reveal">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-500/10 border border-green-500/30 text-green-400 text-sm font-medium backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        Wypożyczalnia czynna 24/7
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight text-white tracking-tight">
                        Twórz filmy.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 to-amber-500">My damy sprzęt.</span>
                    </h1>
                    <p class="text-lg text-slate-300 leading-relaxed max-w-xl">
                        Wypożyczalnia tworzona przez operatorów dla operatorów. Bez ukrytych kosztów, z pełnym supportem technicznym na planie.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#sprzet" class="btn-primary px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold rounded-xl shadow-[0_0_30px_-5px_rgba(245,158,11,0.4)] flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-950 focus:ring-amber-500">
                            Rezerwuj teraz <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="#kontakt" class="px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base bg-slate-900/40 hover:bg-slate-800 text-white font-bold rounded-xl border border-slate-700 transition duration-300 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-950 focus:ring-amber-500">
                            Kontakt
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 reveal delay-200">
                    <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/50 backdrop-blur-md hover:bg-slate-800/60 transition duration-300">
                        <p class="text-sm text-slate-400 mb-1">Dostępny sprzęt</p>
                        <p class="text-4xl font-extrabold text-white counter" data-target="{{ $statystyki['sprzet'] }}">0</p>
                        <div class="h-1 w-12 bg-amber-500 mt-4 rounded-full"></div>
                    </div>
                    <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/50 backdrop-blur-md hover:bg-slate-800/60 transition duration-300">
                        <p class="text-sm text-slate-400 mb-1">Wypożyczenia</p>
                        <p class="text-4xl font-extrabold text-white counter" data-target="{{ $statystyki['wypozyczenia'] }}">0</p>
                         <div class="h-1 w-12 bg-slate-600 mt-4 rounded-full"></div>
                    </div>
                    <div class="p-6 rounded-2xl bg-slate-900/40 border border-slate-800/50 backdrop-blur-md hover:bg-slate-800/60 transition duration-300">
                        <p class="text-sm text-slate-400 mb-1">Klienci</p>
                        <p class="text-4xl font-extrabold text-white counter" data-target="{{ $statystyki['klienci'] }}">0</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-slate-950 border-y border-slate-900/50 relative overflow-hidden">
        <h2 class="sr-only">Zaufali nam producenci</h2>
        <div class="marquee-mask max-w-7xl mx-auto px-4">
            <div class="marquee-container">
                <div class="marquee-content">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/sony.svg" alt="Sony" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/canon.svg" alt="Canon" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/panasonic.svg" alt="Panasonic" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/blackmagicdesign.svg" alt="Blackmagic Design" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/dji.svg" alt="DJI" class="h-10 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/zeiss.svg" alt="ZEISS" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/red.svg" alt="RED" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/sony.svg" alt="Sony" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/canon.svg" alt="Canon" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/panasonic.svg" alt="Panasonic" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/blackmagicdesign.svg" alt="Blackmagic Design" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/dji.svg" alt="DJI" class="h-10 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/zeiss.svg" alt="ZEISS" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/red.svg" alt="RED" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/sony.svg" alt="Sony" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/canon.svg" alt="Canon" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/panasonic.svg" alt="Panasonic" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/blackmagicdesign.svg" alt="Blackmagic Design" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/dji.svg" alt="DJI" class="h-10 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/zeiss.svg" alt="ZEISS" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@11/icons/red.svg" alt="RED" class="h-8 w-auto brightness-0 invert opacity-50 hover:opacity-100 transition-opacity" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <section id="sprzet" class="py-24 bg-slate-950 relative">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-64 bg-amber-500/5 blur-[120px] pointer-events-none" aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <p class="text-amber-400 font-bold tracking-widest text-xs uppercase mb-3">Cinema Grade Gear</p>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Wybierz swój setup</h2>
                <p class="text-slate-400 text-lg">
                    Nie wiesz co wybrać? Nasz <span class="text-amber-400">Zestaw Mid</span> to najczęściej wybierana opcja przez 80% twórców teledysków i reklam.
                </p>
            </div>

            <div class="flex justify-center gap-4 mb-12 reveal" role="group" aria-label="Wybór kategorii sprzętu">
                <button data-category="video" class="category-btn px-6 py-2 rounded-full bg-amber-500 text-black font-bold text-sm shadow-[0_0_20px_-5px_rgba(245,158,11,0.5)] transition hover:scale-105 active focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-950 focus:ring-amber-500">
                    Video & Cinema
                </button>
                <button data-category="photo" class="category-btn px-6 py-2 rounded-full bg-slate-900 border border-slate-700 text-slate-400 font-bold text-sm hover:border-slate-500 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-950 focus:ring-amber-500">
                    Foto & Studio
                </button>
            </div>

            <div id="video-packages" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start reveal">
                
                <div class="group relative bg-slate-900/50 rounded-3xl border border-slate-800 p-8 hover:border-slate-600 transition-all duration-300 hover:-translate-y-2 card-shine overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6 text-slate-300 group-hover:text-white group-hover:bg-slate-700 transition">
                            <i data-lucide="video" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Start Pack</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Idealny do vlogów, wywiadów i prostych realizacji do social media.</p>
                        
                        <div class="text-3xl font-extrabold text-white mb-1">350 zł <span class="text-sm font-medium text-slate-500">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <form action="{{ route('koszyk.dodaj') }}" method="POST" class="mb-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="sprzet_ids" value="1,2,3,4">
                            <button type="submit" class="w-full py-3 rounded-xl border border-slate-700 text-white font-semibold hover:bg-white hover:text-black transition duration-300">
                                Dodaj do koszyka
                            </button>
                        </form>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">W zestawie:</p>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Kamera Sony A7 IV
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Obiektyw 24-70mm
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Mikrofon Rode Wireless
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Gimbal Ronin RS3
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-slate-900 rounded-3xl border border-amber-500/30 p-8 transform lg:-translate-y-6 shadow-[0_0_50px_-15px_rgba(245,158,11,0.15)] transition-all duration-300 hover:shadow-[0_0_70px_-20px_rgba(245,158,11,0.3)] card-shine overflow-hidden ring-1 ring-amber-500/20">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-70"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 blur-[50px] rounded-full pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-black shadow-lg shadow-amber-500/40">
                                <i data-lucide="film" class="w-7 h-7"></i>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-wider">
                                Bestseller
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-2">Creator Pro</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Kompletny zestaw do teledysków, reklam i krótkich metraży.</p>
                        
                        <div class="text-4xl font-extrabold text-amber-400 mb-1">850 zł <span class="text-sm font-medium text-slate-500 text-white">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <form action="{{ route('koszyk.dodaj') }}" method="POST" class="mb-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="sprzet_ids" value="5,6,7,8,9">
                            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-black font-bold shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] transition duration-300">
                                Rezerwuję ten zestaw
                            </button>
                        </form>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-amber-500/70 uppercase tracking-wide">Wszystko z Basic oraz:</p>
                            <ul class="space-y-3 text-sm text-white">
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    <strong>Kamera FX3 / FX6 Cinema</strong>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    Zestaw szkieł Prime G-Master
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    Atomos Ninja V + SSD
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    Oświetlenie Aputure 300d II
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    2x Dron DJI Mavic 3 Cine
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-slate-900/50 rounded-3xl border border-slate-800 p-8 hover:border-slate-600 transition-all duration-300 hover:-translate-y-2 card-shine overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6 text-slate-300 group-hover:text-white group-hover:bg-slate-700 transition">
                            <i data-lucide="clapperboard" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Cinema Production</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Dla domów produkcyjnych. Pełna klatka filmowa i osprzęt gripowy.</p>
                        
                        <div class="text-3xl font-extrabold text-white mb-1">2000 zł <span class="text-sm font-medium text-slate-500">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <form action="{{ route('koszyk.dodaj') }}" method="POST" class="mb-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="sprzet_ids" value="10,11,12,13">
                            <button type="submit" class="w-full py-3 rounded-xl border border-slate-700 text-white font-semibold hover:bg-white hover:text-black transition duration-300">
                                Dodaj do koszyka
                            </button>
                        </form>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Mid + dodatkowo:</p>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> ARRI Alexa Mini / RED V-Raptor
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Obiektywy Cooke / Zeiss CP.3
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> EasyRig + Wireless Follow Focus
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Asystent kamery na planie
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div id="photo-packages" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-6 items-start reveal">
                
                <div class="group relative bg-slate-900/50 rounded-3xl border border-slate-800 p-8 hover:border-slate-600 transition-all duration-300 hover:-translate-y-2 card-shine overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-800/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6 text-slate-300 group-hover:text-white group-hover:bg-slate-700 transition">
                            <i data-lucide="camera" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Studio Light</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Idealny do fotografii produktowej i portretów w studiu.</p>
                        
                        <div class="text-3xl font-extrabold text-white mb-1">400 zł <span class="text-sm font-medium text-slate-500">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <button class="w-full py-3 rounded-xl border border-slate-700 text-white font-semibold hover:bg-white hover:text-black transition duration-300">
                            Rezerwuję
                        </button>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">W zestawie:</p>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Aparat Canon EOS R5
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> 3x oświetlenie LED Godox
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Statyw + rama do tła
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> 10x tła bezszwowe
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-slate-900 rounded-3xl border border-amber-500/30 p-8 transform lg:-translate-y-6 shadow-[0_0_50px_-15px_rgba(245,158,11,0.15)] transition-all duration-300 hover:shadow-[0_0_70px_-20px_rgba(245,158,11,0.3)] card-shine overflow-hidden ring-1 ring-amber-500/20">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-70"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 blur-[50px] rounded-full pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-black shadow-lg shadow-amber-500/40">
                                <i data-lucide="image" class="w-7 h-7"></i>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-wider">
                                Bestseller
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-2">Professional Photo</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Kompletny setup do profesjonalnych sesji fotograficznych.</p>
                        
                        <div class="text-4xl font-extrabold text-amber-400 mb-1">900 zł <span class="text-sm font-medium text-slate-500 text-white">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <button class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-black font-bold shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] transition duration-300">
                            Rezerwuję ten zestaw
                        </button>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-amber-500/70 uppercase tracking-wide">Wszystko z Basic oraz:</p>
                            <ul class="space-y-3 text-sm text-white">
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    <strong>Nikon Z9 + Backup Z8</strong>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    5x obiektywów premium
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    Profesjonalne oświetlenie Profoto
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    System softboxów i odbijników
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="p-1 rounded-full bg-amber-500/20"><i data-lucide="check" class="w-3 h-3 text-amber-400"></i></div>
                                    Studyjne tła i akcesoria
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-slate-900/50 rounded-3xl border border-slate-800 p-8 hover:border-slate-600 transition-all duration-300 hover:-translate-y-2 card-shine overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6 text-slate-300 group-hover:text-white group-hover:bg-slate-700 transition">
                            <i data-lucide="layers" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Studio Plus</h3>
                        <p class="text-slate-400 text-sm mb-6 h-10">Maksymalny setup z dodatkową sesją edycji i retuszu.</p>
                        
                        <div class="text-3xl font-extrabold text-white mb-1">2500 zł <span class="text-sm font-medium text-slate-500">/doba</span></div>
                        <p class="text-xs text-slate-500 mb-8">+ 23% VAT</p>

                        <button class="w-full py-3 rounded-xl border border-slate-700 text-white font-semibold hover:bg-white hover:text-black transition duration-300">
                            Zarezerwuj
                        </button>

                        <div class="mt-8 space-y-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Professional + dodatkowo:</p>
                            <ul class="space-y-3 text-sm text-slate-300">
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Hasselblad H6D + Backup
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Lighting Designer na planie
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> 4x studio setup komplety
                                </li>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="check-circle-2" class="w-5 h-5 text-slate-600"></i> Retusz i edycja 200 zdjęć
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-16 flex justify-center reveal">
                <p class="text-slate-400 text-sm text-center">Potrzebujesz innej konfiguracji? <a href="#kontakt" class="text-amber-400 hover:text-amber-300 underline underline-offset-4">Skompletuj własny koszyk</a> w sklepie.</p>
            </div>
        </div>
    </section>

    <section class="py-16 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 reveal">
            <div class="text-center mb-12">
                <p class="text-amber-300 text-sm font-semibold uppercase tracking-wide mb-2">Portfolio</p>
                <h2 class="text-4xl font-bold text-white mb-4">Nagrane naszym sprzętem</h2>
                <p class="text-xl text-slate-400">Zobacz profesjonalne realizacje wykonane z wykorzystaniem naszego sprzętu</p>
            </div>
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <div class="aspect-video rounded-2xl overflow-hidden border border-slate-800 bg-slate-950">
                    <video 
                        class="w-full h-full object-cover" 
                        controls
                        preload="metadata"
                        poster="{{ asset('video/vid01.mp4') }}">
                        <source src="{{ asset('video/vid01.mp4') }}" type="video/mp4">
                        Twoja przeglądarka nie obsługuje odtwarzacza wideo.
                    </video>
                </div>
                <div class="space-y-6">
                    <div class="p-6 bg-slate-950 border border-slate-800 rounded-xl">
                        <h3 class="text-xl font-bold text-white mb-3">Profesjonalna jakość</h3>
                        <p class="text-slate-400 leading-relaxed">Nasz sprzęt wykorzystywany jest przez profesjonalnych filmowców, fotografów i twórców contentu. Dzięki najwyższej jakości kamerom, obiektywom i oświetleniu, realizacje osiągają kinematograficzny poziom.</p>
                    </div>
                    <div class="p-6 bg-slate-950 border border-slate-800 rounded-xl">
                        <h3 class="text-xl font-bold text-white mb-3">Twoje projekty mogą wyglądać tak samo</h3>
                        <p class="text-slate-400 leading-relaxed">Wynajmij ten sam sprzęt i stwórz własne profesjonalne produkcje. Oferujemy kompleksowe zestawy oraz wsparcie techniczne.</p>
                        <a href="{{ route('sklep') }}" class="inline-flex items-center mt-4 text-amber-400 hover:text-amber-300 font-semibold">
                            Zobacz sprzęt
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontakt" class="py-20 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
            <h2 class="text-4xl font-bold text-white mb-4">Skontaktuj się z nami</h2>
            <p class="text-xl mb-12 text-slate-400">Masz pytania? Chcesz wypożyczyć sprzęt? Napisz do nas!</p>
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

    <footer class="bg-slate-900 border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <p class="text-white font-bold text-lg">FilmoRent</p>
                    <p class="text-slate-400 text-sm mt-2">Pełen serwis sprzętu filmowego: wypożyczenia, sklep i wsparcie techniczne na planie.</p>
                </div>
                <div>
                    <p class="text-white font-bold text-lg mb-2">Regulaminy</p>
                    <p class="text-slate-400 text-sm">Regulamin wypożyczalni: sprzęt wydawany jest po weryfikacji tożsamości i podpisaniu protokołu przekazania, zwroty po kontroli technicznej i potwierdzeniu stanu.</p>
                </div>
                <div>
                    <p class="text-white font-bold text-lg mb-2">Polityka prywatności</p>
                    <p class="text-slate-400 text-sm">Twoje dane wykorzystujemy wyłącznie do realizacji zamówień, rozliczeń i obsługi serwisowej. Nie przekazujemy ich podmiotom trzecim bez zgody.</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-center mt-8 text-slate-500 text-sm">
                <p>&copy; 2026 FilmoRent. Wszystkie prawa zastrzeżone.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#kontakt" class="hover:text-amber-400 transition focus:outline-none focus:ring-2 focus:ring-amber-400 rounded px-2 py-1">Kontakt</a>
                    <a href="/sklep" class="hover:text-amber-400 transition focus:outline-none focus:ring-2 focus:ring-amber-400 rounded px-2 py-1">Sklep</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();

        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    
                    const counters = entry.target.querySelectorAll('.counter');
                    counters.forEach(counter => animateCounter(counter));
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        function animateCounter(el) {
            const target = parseInt(el.getAttribute('data-target'));
            const duration = 2000; 
            const step = target / (duration / 16); 
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.innerText = target;
                    clearInterval(timer);
                } else {
                    el.innerText = Math.floor(current);
                }
            }, 16);
        }

        const categoryBtns = document.querySelectorAll('.category-btn');
        const videoPackages = document.getElementById('video-packages');
        const photoPackages = document.getElementById('photo-packages');

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const category = btn.getAttribute('data-category');
                
                categoryBtns.forEach(b => b.classList.remove('active', 'bg-amber-500', 'text-black', 'shadow-[0_0_20px_-5px_rgba(245,158,11,0.5)]'));
                categoryBtns.forEach(b => b.classList.add('bg-slate-900', 'border', 'border-slate-700', 'text-slate-400'));
                
                btn.classList.add('active', 'bg-amber-500', 'text-black', 'shadow-[0_0_20px_-5px_rgba(245,158,11,0.5)]');
                btn.classList.remove('bg-slate-900', 'border', 'border-slate-700', 'text-slate-400');
                
                if (category === 'video') {
                    videoPackages.classList.remove('hidden');
                    photoPackages.classList.add('hidden');
                } else if (category === 'photo') {
                    photoPackages.classList.remove('hidden');
                    videoPackages.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>

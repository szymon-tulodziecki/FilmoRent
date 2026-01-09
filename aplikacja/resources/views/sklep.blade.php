<!DOCTYPE html>
<html lang="pl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Katalog sprzętu FilmoRent - Kamery, Obiektywy, Światło, Grip.">
    <title>Katalog Sprzętu - FilmoRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    @include('components.styles')
    
    <style>
        .card-shine::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.05), transparent);
            transform: skewX(-15deg) translateX(-150%);
            transition: transform 0.5s;
            pointer-events: none;
        }
        .group:hover .card-shine::after {
            animation: shimmer 1s ease-in-out;
        }
        @keyframes shimmer {
            0% { transform: translateX(-150%) skewX(-15deg); }
            100% { transform: translateX(150%) skewX(-15deg); }
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 16px; width: 16px;
            border-radius: 50%;
            background: #f59e0b;
            cursor: pointer;
            margin-top: -6px;
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%; height: 4px;
            cursor: pointer;
            background: #334155;
            border-radius: 2px;
        }

        #produkty-container[data-view="list"] #produkty-grid {
            display: flex !important;
            flex-direction: column;
            grid-template-columns: none !important;
            gap: 1rem !important;
        }

        #produkty-container[data-view="list"] #produkty-grid article {
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
        }

        #produkty-container[data-view="list"] #produkty-grid article .h-56 {
            flex-shrink: 0;
            width: 250px;
            height: 200px;
        }

        #produkty-container[data-view="list"] #produkty-grid article > div:last-child {
            flex: 1;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-amber-500 selection:text-black">

    @include('components.navbar')

    <section class="py-12 bg-slate-950" id="shop-content">
        <h1 class="sr-only">Katalog sprzętu filmowego</h1>
        <form method="GET" action="{{ route('sklep') }}" id="filter-form">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto relative mb-10">
                    <div class="relative flex items-center bg-slate-900/90 rounded-xl border border-slate-600 shadow-lg">
                        <div class="pl-4 text-slate-500">
                            <i data-lucide="search" class="w-6 h-6"></i>
                        </div>
                        <input type="text" 
                               name="szukaj"
                               value="{{ request('szukaj') }}"
                               class="w-full bg-transparent border-0 py-4 px-4 text-white placeholder-slate-300 focus:ring-0 focus:outline-none text-lg" 
                               placeholder="Czego szukasz? np. Sony FX6, Aputure 300d...">
                        <button type="submit" class="mr-2 px-6 py-2 bg-amber-500 hover:bg-amber-400 text-black font-bold rounded-lg transition focus:outline-none">
                            Szukaj
                        </button>
                    </div>
                </div>
            <div class="flex flex-col lg:flex-row gap-10">
                
                <aside class="w-full lg:w-64 flex-shrink-0 space-y-8 hidden lg:block">
                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-5">
                        <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="grid" class="w-4 h-4 text-amber-500"></i> Kategorie
                        </h2>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <span class="w-5 h-5 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                    <input type="radio" name="kategoria" value="" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ !request('kategoria') ? 'checked' : '' }}>
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-amber-500 opacity-0 peer-checked:opacity-100"></i>
                                </span>
                                <span class="text-slate-200 group-hover:text-white transition">Wszystkie</span>
                            </label>
                            @foreach($kategorie as $kat)
                            <label class="flex items-center space-x-3 cursor-pointer group">
                                <span class="w-5 h-5 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                    <input type="radio" name="kategoria" value="{{ $kat->id }}" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ request('kategoria') == $kat->id ? 'checked' : '' }}>
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-amber-500 opacity-0 peer-checked:opacity-100"></i>
                                </span>
                                <span class="text-slate-200 group-hover:text-white transition">{{ $kat->nazwa }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-slate-700 my-6">

                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-5">
                        <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-amber-500"></i> Cena za dobę
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-slate-300 mb-2 block">Min: <span id="cena-min-val" class="text-amber-400 font-bold">{{ request('cena_min', '0') }}</span> PLN</label>
                                <input type="range" name="cena_min" id="cena-min-input" min="0" max="10000" step="100" value="{{ request('cena_min', '0') }}" class="w-full" onchange="validatePriceRange()">
                            </div>
                            <div>
                                <label class="text-xs text-slate-300 mb-2 block">Max: <span id="cena-max-val" class="text-amber-400 font-bold">{{ request('cena_max', '10000') }}</span> PLN</label>
                                <input type="range" name="cena_max" id="cena-max-input" min="0" max="10000" step="100" value="{{ request('cena_max', '10000') }}" class="w-full" onchange="validatePriceRange()">
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-700 my-6">

                    <div class="bg-slate-900/80 border border-slate-600 rounded-2xl p-5">
                        <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                            <i data-lucide="tag" class="w-4 h-4 text-amber-500"></i> Marka
                        </h2>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-900">
                             @foreach($producenci as $producent)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <span class="w-4 h-4 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                        <input type="checkbox" name="producent[]" value="{{ $producent->id }}" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ in_array($producent->id, (array)request('producent', [])) ? 'checked' : '' }}>
                                        <span class="w-2 h-2 bg-amber-500 rounded-sm opacity-0 peer-checked:opacity-100"></span>
                                    </span>
                                    <span class="text-sm text-slate-200 group-hover:text-white transition">{{ $producent->nazwa }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <div class="lg:hidden w-full mb-6">
                    <button type="button" id="toggle-filters" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-800 rounded-xl border border-slate-700 text-white font-semibold">
                        <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
                        Filtrowanie i Sortowanie
                    </button>
                    <div id="mobile-filters-content" class="hidden mt-4 bg-slate-900 p-6 rounded-xl border border-slate-800 space-y-6">
                        <!-- Kategorie -->
                        <div>
                            <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                                <i data-lucide="grid" class="w-4 h-4 text-amber-500"></i> Kategorie
                            </h2>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <span class="w-5 h-5 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                        <input type="radio" name="kategoria" value="" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ !request('kategoria') ? 'checked' : '' }}>
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-500 opacity-0 peer-checked:opacity-100"></i>
                                    </span>
                                    <span class="text-slate-200 group-hover:text-white transition">Wszystkie</span>
                                </label>
                                @foreach($kategorie as $kat)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <span class="w-5 h-5 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                        <input type="radio" name="kategoria" value="{{ $kat->id }}" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ request('kategoria') == $kat->id ? 'checked' : '' }}>
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-amber-500 opacity-0 peer-checked:opacity-100"></i>
                                    </span>
                                    <span class="text-slate-200 group-hover:text-white transition">{{ $kat->nazwa }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="border-slate-700">

                        <!-- Cena -->
                        <div>
                            <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                                <i data-lucide="dollar-sign" class="w-4 h-4 text-amber-500"></i> Cena za dobę
                            </h2>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <input type="number" name="cena_min" id="cena-min-input-mobile" value="{{ request('cena_min', 0) }}" min="0" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm" placeholder="Min" onchange="document.getElementById('filter-form').submit()">
                                    <span class="text-slate-400">-</span>
                                    <input type="number" name="cena_max" id="cena-max-input-mobile" value="{{ request('cena_max', 10000) }}" max="10000" class="w-full bg-slate-800 border border-slate-600 rounded-lg px-3 py-2 text-white text-sm" placeholder="Max" onchange="document.getElementById('filter-form').submit()">
                                </div>
                            </div>
                        </div>

                        <hr class="border-slate-700">

                        <!-- Producenci -->
                        <div>
                            <h2 class="text-white font-bold mb-4 flex items-center gap-2">
                                <i data-lucide="package" class="w-4 h-4 text-amber-500"></i> Marka
                            </h2>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($producenci as $producent)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <span class="w-4 h-4 rounded border border-slate-500 bg-slate-900 flex items-center justify-center group-hover:border-amber-500 transition">
                                        <input type="checkbox" name="producent[]" value="{{ $producent->id }}" onchange="document.getElementById('filter-form').submit()" class="hidden peer" {{ in_array($producent->id, (array)request('producent', [])) ? 'checked' : '' }}>
                                        <span class="w-2 h-2 bg-amber-500 rounded-sm opacity-0 peer-checked:opacity-100"></span>
                                    </span>
                                    <span class="text-sm text-slate-200 group-hover:text-white transition">{{ $producent->nazwa }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                        <p class="text-slate-200 text-sm">Znaleziono <span class="text-white font-bold" id="produkty-count">{{ $sprzety->total() }}</span> produktów</p>
                        
                        <div class="flex flex-wrap gap-3 items-center">
                            <!-- Wyświetlanie -->
                            <div class="flex items-center gap-2 bg-slate-900/90 rounded-lg border border-slate-600 p-2">
                                <button id="grid-view" class="p-2 rounded hover:bg-slate-800 transition text-amber-500" title="Siatka">
                                    <i data-lucide="grid" class="w-4 h-4"></i>
                                </button>
                                <button id="list-view" class="p-2 rounded hover:bg-slate-800 transition text-slate-500" title="Lista">
                                    <i data-lucide="list" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <select id="per-page-select" class="bg-slate-900/90 border border-slate-600 text-slate-100 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 p-2.5">
                                <option value="9" {{ request('per_page', '9') == '9' ? 'selected' : '' }}>9 na stronie</option>
                                <option value="15" {{ request('per_page', '9') == '15' ? 'selected' : '' }}>15 na stronie</option>
                                <option value="30" {{ request('per_page', '9') == '30' ? 'selected' : '' }}>30 na stronie</option>
                                <option value="60" {{ request('per_page', '9') == '60' ? 'selected' : '' }}>60 na stronie</option>
                            </select>

                            <select id="sortowanie-select" class="bg-slate-900/90 border border-slate-600 text-slate-100 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 p-2.5">
                                <option value="najnowsze" {{ request('sortowanie') == 'najnowsze' ? 'selected' : '' }}>Najnowsze</option>
                                <option value="cena_rosnaco" {{ request('sortowanie') == 'cena_rosnaco' ? 'selected' : '' }}>Cena: rosnąco</option>
                                <option value="cena_malejaco" {{ request('sortowanie') == 'cena_malejaco' ? 'selected' : '' }}>Cena: malejąco</option>
                                <option value="nazwa" {{ request('sortowanie') == 'nazwa' ? 'selected' : '' }}>Nazwa: A-Z</option>
                            </select>
                        </div>
                    </div>

                    <div id="produkty-container" data-view="grid">
                        @include('partials.produkty', ['sprzety' => $sprzety])
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

    @include('components.footer')

    <script>
        lucide.createIcons();

        const toggleBtn = document.getElementById('toggle-filters');
        const mobileFilters = document.getElementById('mobile-filters-content');
        
        if(toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                mobileFilters.classList.toggle('hidden');
            });
        }

        let searchTimeout;
        function debounceSearch(fn, delay = 500) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(fn, delay);
        }

        function loadProducts(page = 1) {
            const szukaj = document.querySelector('input[name="szukaj"]').value;
            const kategoria = document.querySelector('input[name="kategoria"]:checked')?.value || '';
            const producenti = Array.from(document.querySelectorAll('input[name="producent[]"]:checked')).map(el => el.value);
            const sortowanie = document.getElementById('sortowanie-select').value;
            const cena_min = document.querySelector('input[name="cena_min"]').value;
            const cena_max = document.querySelector('input[name="cena_max"]').value;
            const per_page = document.getElementById('per-page-select').value;

            const params = new URLSearchParams({
                szukaj: szukaj,
                kategoria: kategoria,
                sortowanie: sortowanie,
                cena_min: cena_min,
                cena_max: cena_max,
                per_page: per_page,
                page: page
            });

            if (producenti.length > 0) {
                producenti.forEach(p => params.append('producent[]', p));
            }

            fetch(`{{ route('sklep.products') }}?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('produkty-container').innerHTML = data.html;
                    document.getElementById('produkty-count').textContent = data.total;
                    lucide.createIcons();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(error => console.error('Error:', error));
        }

        function loadPage(page) {
            loadProducts(page);
        }

        function validatePriceRange() {
            const minInput = document.getElementById('cena-min-input');
            const maxInput = document.getElementById('cena-max-input');
            const minVal = parseInt(minInput.value);
            const maxVal = parseInt(maxInput.value);

            if (minVal > maxVal) {
                maxInput.value = minVal;
                document.getElementById('cena-max-val').textContent = minVal;
            }

            if (maxVal < minVal) {
                minInput.value = maxVal;
                document.getElementById('cena-min-val').textContent = maxVal;
            }

            document.getElementById('cena-min-val').textContent = minInput.value;
            document.getElementById('cena-max-val').textContent = maxInput.value;
            
            loadProducts(1);
        }

        document.querySelectorAll('input[name="kategoria"]').forEach(el => {
            el.addEventListener('change', () => loadProducts(1));
        });

        document.querySelectorAll('input[name="producent[]"]').forEach(el => {
            el.addEventListener('change', () => loadProducts(1));
        });

        document.querySelector('input[name="szukaj"]').addEventListener('keyup', () => {
            debounceSearch(() => loadProducts(1), 300);
        });

        document.getElementById('sortowanie-select').addEventListener('change', () => {
            loadProducts(1);
        });

        document.getElementById('per-page-select').addEventListener('change', () => {
            loadProducts(1);
        });

        const gridViewBtn = document.getElementById('grid-view');
        const listViewBtn = document.getElementById('list-view');
        const produktyContainer = document.getElementById('produkty-container');

        gridViewBtn.addEventListener('click', () => {
            produktyContainer.setAttribute('data-view', 'grid');
            gridViewBtn.classList.remove('text-slate-500');
            gridViewBtn.classList.add('text-amber-500');
            listViewBtn.classList.remove('text-amber-500');
            listViewBtn.classList.add('text-slate-500');
        });

        listViewBtn.addEventListener('click', () => {
            produktyContainer.setAttribute('data-view', 'list');
            listViewBtn.classList.remove('text-slate-500');
            listViewBtn.classList.add('text-amber-500');
            gridViewBtn.classList.remove('text-amber-500');
            gridViewBtn.classList.add('text-slate-500');
        });
    </script>

</body>
</html>
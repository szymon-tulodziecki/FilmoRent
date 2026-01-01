<div class="container mx-auto px-4 py-8">
    
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Wypożyczalnia Sprzętu</h1>
        <p class="text-lg text-gray-600">Profesjonalne kamery, obiektywy i oświetlenie na wyciągnięcie ręki.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <aside class="w-full lg:w-1/4" aria-label="Filtrowanie produktów">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 sticky top-24">
                <h2 class="text-xl font-bold mb-4 text-gray-900 border-b pb-2">Filtry</h2>

                <div class="mb-6">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Szukaj sprzętu</label>
                    <input wire:model.live.debounce.300ms="wyszukiwarka" 
                           type="search" id="search" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="Np. Sony FX3...">
                </div>

                <div class="mb-6">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategoria</label>
                    <select wire:model.live="wybranaKategoria" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Wszystkie kategorie</option>
                        @foreach($kategorie as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nazwa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sortowanie</label>
                    <select wire:model.live="sortowanie" id="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="popularnosc">Domyślne</option>
                        <option value="cena_rosnaco">Cena: od najniższej</option>
                        <option value="cena_malejaco">Cena: od najwyższej</option>
                    </select>
                </div>
            </div>
        </aside>

        <section class="w-full lg:w-3/4" aria-label="Lista dostępnego sprzętu">
            
            <div wire:loading class="w-full text-center py-4 text-blue-600 font-semibold">
                Ładowanie oferty...
            </div>

            @if($sprzety->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <p class="text-yellow-700">Nie znaleziono sprzętu spełniającego kryteria.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sprzety as $item)
                        <article class="flex flex-col bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group focus-within:ring-4 focus-within:ring-blue-500">
                            
                            <div class="bg-gray-200 h-48 w-full flex items-center justify-center overflow-hidden">
                                <span class="text-gray-400 text-4xl">📷</span>
                            </div>

                            <div class="p-4 flex flex-col flex-grow">
                                <div class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">
                                    {{ $item->kategoria->nazwa }}
                                </div>
                                
                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">
                                    <a href="{{ url('/sprzet/'.$item->id) }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $item->nazwa }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $item->opis }}
                                </p>

                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-2xl font-bold text-gray-900">{{ number_format($item->cena_doba, 0) }} zł</span>
                                        <span class="text-xs text-gray-500">/ doba (+ kaucja)</span>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                                        Dostępny
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $sprzety->links() }}
                </div>
            @endif
        </section>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="produkty-grid" data-view="grid">
    @forelse($sprzety as $item)
    <article class="group relative bg-slate-900/90 rounded-2xl border border-slate-600 overflow-hidden card-hover hover:border-amber-500/60 card-shine flex flex-col h-full">
        <a href="{{ route('produkt.show', $item) }}" class="h-56 overflow-hidden relative bg-slate-800 block">
            <div class="absolute top-3 left-3 z-20">
                <span class="bg-black/75 backdrop-blur-md text-[10px] font-bold px-2 py-1 rounded text-white border border-white/20 uppercase tracking-wider">
                    {{ $item->kategoria->nazwa ?? 'Sprzęt' }}
                </span>
            </div>
            
            @if($item->status_sprzetu === 'dostepny')
            <div class="absolute top-3 right-3 z-20">
                <span class="flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
            </div>
            @endif

            <img src="{{ $item->getZdjecieUrl() }}"
                 alt="{{ $item->nazwa }}"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-95 group-hover:opacity-100">
            
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3 backdrop-blur-[2px]">
                <span class="p-3 bg-white text-black rounded-full hover:bg-amber-400 transition transform translate-y-4 group-hover:translate-y-0 duration-300 shadow-lg" title="Zobacz szczegóły">
                    <i data-lucide="eye" class="w-5 h-5"></i>
                </span>
            </div>
        </a>

        <div class="p-5 flex flex-col flex-grow">
            <div class="mb-auto">
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="box" class="w-3 h-3 text-amber-500"></i>
                    <span class="text-xs text-slate-200 uppercase font-semibold tracking-wide">{{ $item->producent->nazwa ?? 'Producent' }}</span>
                </div>
                <a href="{{ route('produkt.show', $item) }}">
                    <h3 class="text-lg font-bold text-white group-hover:text-amber-400 transition-colors leading-tight mb-2">
                        {{ $item->nazwa }}
                    </h3>
                </a>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="text-[10px] bg-slate-800 text-slate-200 px-1.5 py-0.5 rounded border border-slate-500">{{ $item->status_sprzetu }}</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-700 flex items-center justify-between mt-2">
                <div>
                    <p class="text-xs text-slate-300">Cena za dzień</p>
                    <p class="text-xl font-bold text-white">{{ number_format($item->cena_doba, 0, ',', ' ') }} zł</p>
                </div>
                <a href="{{ route('produkt.show', $item) }}" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-black text-sm font-bold shadow-lg shadow-amber-500/20 transition-all active:scale-95 flex items-center gap-2">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                    Zobacz
                </a>
            </div>
        </div>
    </article>
    @empty
    <div class="col-span-full">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Nie znaleziono produktów spełniających kryteria.</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Paginacja -->
@if ($sprzety->hasPages())
<div class="mt-12 flex justify-center">
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        {{-- Previous Page Link --}}
        @if ($sprzety->onFirstPage())
        <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-slate-600 ring-1 ring-inset ring-slate-700 cursor-not-allowed">
            <span class="sr-only">Previous</span>
            <i data-lucide="chevron-left" class="h-5 w-5"></i>
        </span>
        @else
        <a href="#" onclick="loadPage({{ $sprzety->currentPage() - 1 }}); return false;" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-slate-400 ring-1 ring-inset ring-slate-700 hover:bg-slate-800 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Previous</span>
            <i data-lucide="chevron-left" class="h-5 w-5"></i>
        </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($sprzety->getUrlRange(1, $sprzety->lastPage()) as $page => $url)
            @if ($page == $sprzety->currentPage())
            <span aria-current="page" class="relative z-10 inline-flex items-center bg-amber-500 px-4 py-2 text-sm font-semibold text-black">{{ $page }}</span>
            @else
            <a href="#" onclick="loadPage({{ $page }}); return false;" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-300 ring-1 ring-inset ring-slate-700 hover:bg-slate-800">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($sprzety->hasMorePages())
        <a href="#" onclick="loadPage({{ $sprzety->currentPage() + 1 }}); return false;" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-slate-400 ring-1 ring-inset ring-slate-700 hover:bg-slate-800 focus:z-20 focus:outline-offset-0">
            <span class="sr-only">Next</span>
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </a>
        @else
        <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-slate-600 ring-1 ring-inset ring-slate-700 cursor-not-allowed">
            <span class="sr-only">Next</span>
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </span>
        @endif
    </nav>
</div>
@endif

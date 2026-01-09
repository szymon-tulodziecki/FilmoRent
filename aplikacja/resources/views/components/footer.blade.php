<footer class="bg-slate-900 border-t border-slate-800 py-12 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 mb-8">
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

        <div class="flex flex-col md:flex-row justify-between items-center pt-8 border-t border-slate-800 text-slate-500 text-sm">
            <p>&copy; 2026 FilmoRent. Wszystkie prawa zastrzeżone.</p>
            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="{{ route('kontakt') }}" class="hover:text-amber-400 transition focus:outline-none focus:ring-2 focus:ring-amber-400 rounded px-2 py-1">Kontakt</a>
                <a href="{{ route('sklep') }}" class="hover:text-amber-400 transition focus:outline-none focus:ring-2 focus:ring-amber-400 rounded px-2 py-1">Sklep</a>
                <a href="{{ route('polityka-prywatnosci') }}" class="hover:text-amber-400 transition focus:outline-none focus:ring-2 focus:ring-amber-400 rounded px-2 py-1">Polityka Prywatności</a>
            </div>
        </div>
    </div>
</footer>

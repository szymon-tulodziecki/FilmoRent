<nav class="bg-slate-900/90 backdrop-blur-md border-b border-slate-600 sticky top-0 z-50">
    <a href="#main-content" class="skip-to-content">Przejdź do głównej treści</a>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-3 group focus:outline-none rounded" aria-label="FilmoRent - Strona główna">
                <span class="inline-flex items-center justify-center w-11 h-11 rounded-xl bg-amber-500/15 border border-amber-500/40 text-amber-400">
                    <i data-lucide="camera" class="w-6 h-6"></i>
                </span>
                <div class="leading-tight">
                    <p class="text-lg font-bold text-white group-hover:text-amber-300 transition">FilmoRent Studio</p>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="/" class="text-slate-200 hover:text-amber-400 transition rounded px-2 py-1" aria-current="page">Główna</a>
                <a href="/sklep" class="text-slate-200 hover:text-amber-400 transition rounded px-2 py-1">Sklep</a>
                <a href="/o-nas" class="text-slate-200 hover:text-amber-400 transition rounded px-2 py-1">O nas</a>
                <a href="/kontakt" class="text-slate-200 hover:text-amber-400 transition rounded px-2 py-1">Kontakt</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-toggle" class="md:hidden p-2 text-slate-200 hover:text-amber-400 transition rounded-lg border border-slate-600 bg-slate-800/70" aria-label="Toggle mobile menu" aria-expanded="false">
                <i data-lucide="menu" class="w-6 h-6" id="menu-icon"></i>
                <i data-lucide="x" class="w-6 h-6 hidden" id="close-icon"></i>
            </button>

            <div class="flex items-center gap-3">
                <!-- ACCESSIBILITY BUTTONS -->
                <div class="hidden lg:flex items-center gap-1 px-2 py-1 bg-slate-800/70 border border-slate-600 rounded-lg">
                    <button id="font-size-decrease" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Zmniejsz rozmiar czcionki" title="A-">A-</button>
                    <button id="font-size-reset" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Przywróć rozmiar czcionki" title="Reset">A</button>
                    <button id="font-size-increase" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Zwiększ rozmiar czcionki" title="A+">A+</button>
                    <div class="w-px h-4 bg-slate-600"></div>
                    <button id="high-contrast" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Włącz wysoki kontrast" title="Kontrast">◐</button>
                    <button id="dyslexia-font" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Czcionka dla dysleksji" title="Dysleksja">D</button>
                    <div class="w-px h-4 bg-slate-600"></div>
                    <button id="reset-all-styles" class="p-1 text-xs rounded hover:bg-slate-700 text-slate-200 transition" aria-label="Przywróć wszystkie ustawienia" title="Reset">⟲</button>
                </div>

                @if(Auth::check())
                    <a href="{{ route('konto') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-800/70 border border-slate-600 text-slate-200 hover:border-amber-500 transition text-sm font-semibold hidden md:flex">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>{{ Auth::user()->imie }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline hidden md:block">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-800/70 border border-slate-600 text-slate-200 hover:border-red-500 hover:text-red-400 transition text-sm font-semibold">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span>Wyloguj</span>
                        </button>
                    </form>
                    <div class="w-px h-8 bg-slate-600 hidden md:block"></div>
                @else
                    <a href="{{ route('logowanie') }}" class="text-sm font-semibold text-slate-200 hover:text-amber-400 transition rounded px-2 py-1 hidden md:block">Logowanie</a>
                @endif

                <a href="{{ route('koszyk') }}" class="relative inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/30 hover:bg-amber-400 transition hidden md:inline-flex" aria-label="Koszyk">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span>Koszyk</span>
                    @php $cartCount = count(session()->get('koszyk', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-700">
            <div class="px-4 py-4 space-y-3">
                <a href="/" class="block px-4 py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-800/70 rounded-lg transition">Główna</a>
                <a href="/sklep" class="block px-4 py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-800/70 rounded-lg transition">Sklep</a>
                <a href="/o-nas" class="block px-4 py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-800/70 rounded-lg transition">O nas</a>
                <a href="/kontakt" class="block px-4 py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-800/70 rounded-lg transition">Kontakt</a>
                
                <div class="pt-3 border-t border-slate-700 space-y-3">
                    <a href="{{ route('koszyk') }}" class="relative flex items-center justify-between px-4 py-3 bg-amber-500 text-black font-bold rounded-lg hover:bg-amber-400 transition">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>Koszyk</span>
                        </div>
                        @php $cartCount = count(session()->get('koszyk', [])); @endphp
                        @if($cartCount > 0)
                            <span class="w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @if(Auth::check())
                        <a href="{{ route('konto') }}" class="flex items-center gap-2 px-4 py-3 bg-slate-800/70 border border-slate-600 text-slate-200 hover:border-amber-500 rounded-lg transition font-semibold">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <span>Moje konto</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 bg-slate-800/70 border border-slate-600 text-slate-200 hover:border-red-500 hover:text-red-400 rounded-lg transition font-semibold">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                <span>Wyloguj</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('logowanie') }}" class="block px-4 py-3 text-center bg-slate-800/70 border border-slate-600 text-slate-200 hover:border-amber-500 hover:text-amber-400 font-bold rounded-lg transition">Logowanie</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenuToggle?.addEventListener('click', () => {
        const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
        
        mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenuToggle?.contains(e.target) && !mobileMenu?.contains(e.target)) {
            mobileMenu?.classList.add('hidden');
            menuIcon?.classList.remove('hidden');
            closeIcon?.classList.add('hidden');
            mobileMenuToggle?.setAttribute('aria-expanded', 'false');
        }
    });
});

// Accessibility Controls - Global Script for All Pages
document.addEventListener('DOMContentLoaded', () => {
    const fontSizeDecrease = document.getElementById('font-size-decrease');
    const fontSizeReset = document.getElementById('font-size-reset');
    const fontSizeIncrease = document.getElementById('font-size-increase');
    const highContrast = document.getElementById('high-contrast');
    const dyslexiaFont = document.getElementById('dyslexia-font');
    const resetAllStyles = document.getElementById('reset-all-styles');

    let currentFontSize = 100;

    // Load saved accessibility settings on page load
    const savedFontSize = localStorage.getItem('fontSize');
    if (savedFontSize) {
        currentFontSize = parseInt(savedFontSize);
        document.documentElement.style.fontSize = (currentFontSize / 100) * 16 + 'px';
    }

    if (localStorage.getItem('highContrast') === 'true') {
        document.body.classList.add('high-contrast');
        highContrast?.classList.add('bg-amber-500', 'text-black');
        highContrast?.classList.remove('bg-slate-800', 'text-slate-200');
    }

    if (localStorage.getItem('dyslexiaFont') === 'true') {
        document.body.classList.add('dyslexia-font');
        dyslexiaFont?.classList.add('bg-amber-500', 'text-black');
        dyslexiaFont?.classList.remove('bg-slate-800', 'text-slate-200');
    }

    // Font size decrease
    fontSizeDecrease?.addEventListener('click', () => {
        if (currentFontSize > 80) {
            currentFontSize -= 10;
            document.documentElement.style.fontSize = (currentFontSize / 100) * 16 + 'px';
            localStorage.setItem('fontSize', currentFontSize);
        }
    });

    // Font size reset
    fontSizeReset?.addEventListener('click', () => {
        currentFontSize = 100;
        document.documentElement.style.fontSize = '16px';
        localStorage.removeItem('fontSize');
        localStorage.removeItem('highContrast');
        localStorage.removeItem('dyslexiaFont');
        document.body.classList.remove('high-contrast', 'dyslexia-font');
        highContrast?.classList.remove('bg-amber-500', 'text-black');
        highContrast?.classList.add('bg-slate-800', 'text-slate-200');
        dyslexiaFont?.classList.remove('bg-amber-500', 'text-black');
        dyslexiaFont?.classList.add('bg-slate-800', 'text-slate-200');
    });

    // Font size increase
    fontSizeIncrease?.addEventListener('click', () => {
        if (currentFontSize < 140) {
            currentFontSize += 10;
            document.documentElement.style.fontSize = (currentFontSize / 100) * 16 + 'px';
            localStorage.setItem('fontSize', currentFontSize);
        }
    });

    // High contrast toggle
    highContrast?.addEventListener('click', () => {
        document.body.classList.toggle('high-contrast');
        highContrast.classList.toggle('bg-amber-500');
        highContrast.classList.toggle('text-black');
        highContrast.classList.toggle('bg-slate-800');
        highContrast.classList.toggle('text-slate-200');
        localStorage.setItem('highContrast', document.body.classList.contains('high-contrast'));
    });

    // Dyslexia font toggle
    dyslexiaFont?.addEventListener('click', () => {
        document.body.classList.toggle('dyslexia-font');
        dyslexiaFont.classList.toggle('bg-amber-500');
        dyslexiaFont.classList.toggle('text-black');
        dyslexiaFont.classList.toggle('bg-slate-800');
        dyslexiaFont.classList.toggle('text-slate-200');
        localStorage.setItem('dyslexiaFont', document.body.classList.contains('dyslexia-font'));
    });

    // Reset all styles to default
    resetAllStyles?.addEventListener('click', () => {
        currentFontSize = 100;
        document.documentElement.style.fontSize = '16px';
        localStorage.clear();
        document.body.classList.remove('high-contrast', 'dyslexia-font');
        highContrast?.classList.remove('bg-amber-500', 'text-black');
        highContrast?.classList.add('bg-slate-800', 'text-slate-200');
        dyslexiaFont?.classList.remove('bg-amber-500', 'text-black');
        dyslexiaFont?.classList.add('bg-slate-800', 'text-slate-200');
        resetAllStyles.blur();
    });
});
</script>

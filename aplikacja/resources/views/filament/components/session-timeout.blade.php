<!-- System timeout sesji z odliczaniem na pasku tytułu -->
<div x-data="{
    // 10 minut w sekundach
    timeout: 10 * 60,
    remaining: 10 * 60,
    warningThreshold: 60,
    interval: null,
    originalTitle: document.title,
    isWarning: false,
    blinkState: false,
    blinkInterval: null,
    
    init() {
        this.resetTimer();
        
        // Resetuj przy aktywności użytkownika
        ['mousedown', 'mousemove', 'keydown', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, () => this.resetTimer(), { passive: true });
        });
        
        // Rozpocznij odliczanie
        this.interval = setInterval(() => this.tick(), 1000);
    },
    
    resetTimer() {
        this.remaining = this.timeout;
        this.isWarning = false;
        this.stopBlinking();
        document.title = this.originalTitle;
    },
    
    tick() {
        this.remaining--;
        
        if (this.remaining <= 0) {
            this.logout();
            return;
        }
        
        // Rozpocznij ostrzeganie gdy zostało < 60 sekund
        if (this.remaining <= this.warningThreshold) {
            this.isWarning = true;
            this.updateTitle();
            
            if (!this.blinkInterval) {
                this.startBlinking();
            }
        }
    },
    
    updateTitle() {
        const minutes = Math.floor(this.remaining / 60);
        const seconds = this.remaining % 60;
        const timeStr = minutes > 0 
            ? `${minutes}:${seconds.toString().padStart(2, '0')}` 
            : `${seconds}s`;
        
        if (this.blinkState) {
            document.title = `⚠️ WYLOGOWANIE ZA ${timeStr} ⚠️`;
        } else {
            document.title = `🔴 WYLOGOWANIE ZA ${timeStr} 🔴`;
        }
    },
    
    startBlinking() {
        this.blinkInterval = setInterval(() => {
            this.blinkState = !this.blinkState;
            this.updateTitle();
        }, 500);
    },
    
    stopBlinking() {
        if (this.blinkInterval) {
            clearInterval(this.blinkInterval);
            this.blinkInterval = null;
        }
        this.blinkState = false;
    },
    
    logout() {
        clearInterval(this.interval);
        this.stopBlinking();
        document.title = '🔒 Sesja wygasła - FilmoRent';
        
        // Wyloguj użytkownika
        window.location.href = '{{ route('filament.admin.auth.logout') }}';
    },
    
    formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    },
    
    extendSession() {
        this.resetTimer();
    }
}" x-cloak>
    <!-- Pasek ostrzeżenia o wygasającej sesji -->
    <div 
        x-show="isWarning"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-full"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-full"
        :class="blinkState ? 'bg-red-600' : 'bg-red-700'"
        class="fixed top-0 left-0 right-0 z-[9999] py-3 px-4 text-white text-center shadow-lg transition-colors duration-300">
        <div class="flex items-center justify-center gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                <span class="font-semibold text-lg">
                    ⏱️ Sesja wygasa za: 
                    <span class="font-bold text-xl" x-text="formatTime(remaining)"></span>
                </span>
            </div>
            <button 
                @click="extendSession()"
                type="button"
                class="px-4 py-1.5 bg-white text-red-700 font-semibold rounded-lg hover:bg-gray-100 transition-colors shadow">
                🔄 Przedłuż sesję
            </button>
        </div>
    </div>
    
    <!-- Mały wskaźnik czasu w prawym dolnym rogu (zawsze widoczny) -->
    <div 
        x-show="!isWarning"
        class="fixed bottom-4 right-4 z-50 bg-gray-800/80 dark:bg-gray-700/80 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm"
        title="Czas do automatycznego wylogowania">
        <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span x-text="formatTime(remaining)"></span>
        </span>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

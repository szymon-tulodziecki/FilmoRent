<div class="fi-wi-accessibility" x-data="{
    fontSize: $persist(100).as('accessibility-font-size'),
    highContrast: $persist(false).as('accessibility-high-contrast'),
    darkMode: $persist(false).as('accessibility-dark-mode'),
    
    init() {
        this.applySettings();
        this.$watch('fontSize', () => this.applySettings());
        this.$watch('highContrast', () => this.applySettings());
        this.$watch('darkMode', () => this.applySettings());
    },
    
    applySettings() {
        document.documentElement.style.fontSize = this.fontSize + '%';
        
        if (this.highContrast) {
            document.documentElement.classList.add('high-contrast');
        } else {
            document.documentElement.classList.remove('high-contrast');
        }
        
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    
    increaseFontSize() {
        if (this.fontSize < 200) {
            this.fontSize += 10;
        }
    },
    
    decreaseFontSize() {
        if (this.fontSize > 80) {
            this.fontSize -= 10;
        }
    },
    
    resetFontSize() {
        this.fontSize = 100;
    },
    
    toggleHighContrast() {
        this.highContrast = !this.highContrast;
    },
    
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
    }
}">
    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="fi-section-header flex flex-col gap-3 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="grid flex-1 gap-y-1">
                    <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        <svg class="inline-block w-5 h-5 mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Ustawienia Dostępności
                    </h3>
                    <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                        Dostosuj interfejs do swoich potrzeb - rozmiar tekstu, kontrast i tryb kolorów
                    </p>
                </div>
            </div>
        </div>
        
        <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
            <div class="fi-section-content px-6 py-4">
                <div class="grid gap-6 md:grid-cols-3">
                    
                    <!-- Rozmiar Czcionki -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                🔤 Rozmiar Tekstu
                            </label>
                            <span class="text-sm font-semibold text-primary-600 dark:text-primary-400" x-text="fontSize + '%'"></span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <button 
                                type="button"
                                @click="decreaseFontSize()"
                                :disabled="fontSize <= 80"
                                class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20 disabled:opacity-50 disabled:cursor-not-allowed"
                                aria-label="Zmniejsz czcionkę">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                </svg>
                            </button>
                            
                            <div class="flex-1">
                                <input 
                                    type="range" 
                                    x-model.number="fontSize" 
                                    min="80" 
                                    max="200" 
                                    step="10"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                    aria-label="Suwak rozmiaru czcionki">
                            </div>
                            
                            <button 
                                type="button"
                                @click="increaseFontSize()"
                                :disabled="fontSize >= 200"
                                class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20 disabled:opacity-50 disabled:cursor-not-allowed"
                                aria-label="Zwiększ czcionkę">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                            
                            <button 
                                type="button"
                                @click="resetFontSize()"
                                class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20"
                                aria-label="Resetuj rozmiar czcionki">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Wysoki Kontrast -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            ⚫⚪ Wysoki Kontrast
                        </label>
                        <button 
                            type="button"
                            @click="toggleHighContrast()"
                            :class="highContrast ? 'bg-primary-600 hover:bg-primary-700' : 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600'"
                            class="w-full fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-size-md gap-1.5 px-4 py-3 text-sm inline-grid shadow-sm text-white ring-1 ring-gray-950/10 dark:ring-white/20"
                            role="switch"
                            :aria-checked="highContrast.toString()">
                            <template x-if="highContrast">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Wysoki kontrast włączony</span>
                                </div>
                            </template>
                            <template x-if="!highContrast">
                                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Włącz wysoki kontrast</span>
                                </div>
                            </template>
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Zwiększa kontrast kolorów dla lepszej czytelności
                        </p>
                    </div>
                    
                    <!-- Tryb Ciemny -->
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            🌙 Tryb Ciemny
                        </label>
                        <button 
                            type="button"
                            @click="toggleDarkMode()"
                            :class="darkMode ? 'bg-gray-800 hover:bg-gray-900' : 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600'"
                            class="w-full fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-size-md gap-1.5 px-4 py-3 text-sm inline-grid shadow-sm text-white ring-1 ring-gray-950/10 dark:ring-white/20"
                            role="switch"
                            :aria-checked="darkMode.toString()">
                            <template x-if="darkMode">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                    </svg>
                                    <span>Tryb ciemny włączony</span>
                                </div>
                            </template>
                            <template x-if="!darkMode">
                                <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                    </svg>
                                    <span>Włącz tryb ciemny</span>
                                </div>
                            </template>
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Ciemne tło dla redukcji zmęczenia oczu
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

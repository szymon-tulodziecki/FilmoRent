<!-- Toolbar dostępności w górnym pasku - tylko rozmiar czcionki i wysoki kontrast -->
<div 
    x-data="{
        fontSize: 100,
        highContrast: false,
        dyslexiaFont: false,
        
        init() {
            // Odczytaj z localStorage
            const savedFontSize = localStorage.getItem('accessibility-font-size');
            const savedContrast = localStorage.getItem('accessibility-high-contrast');
            const savedDyslexia = localStorage.getItem('accessibility-dyslexia-font');
            
            if (savedFontSize) this.fontSize = parseInt(savedFontSize);
            if (savedContrast) this.highContrast = savedContrast === 'true';
            if (savedDyslexia) this.dyslexiaFont = savedDyslexia === 'true';
            
            this.applySettings();
            this.$watch('fontSize', (val) => {
                localStorage.setItem('accessibility-font-size', val);
                this.applySettings();
            });
            this.$watch('highContrast', (val) => {
                localStorage.setItem('accessibility-high-contrast', val);
                this.applySettings();
            });
            this.$watch('dyslexiaFont', (val) => {
                localStorage.setItem('accessibility-dyslexia-font', val);
                this.applySettings();
            });
        },
        
        applySettings() {
            document.documentElement.style.fontSize = this.fontSize + '%';
            
            if (this.highContrast) {
                document.documentElement.classList.add('high-contrast');
            } else {
                document.documentElement.classList.remove('high-contrast');
            }
            
            if (this.dyslexiaFont) {
                document.documentElement.classList.add('dyslexia-font');
            } else {
                document.documentElement.classList.remove('dyslexia-font');
            }
        }
    }"
    class="flex items-center gap-1 ml-4">
    
    <!-- Zmniejsz czcionkę -->
    <button 
        type="button"
        @click="fontSize = Math.max(80, fontSize - 10)"
        :disabled="fontSize <= 80"
        class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
        title="Zmniejsz czcionkę (WCAG)"
        aria-label="Zmniejsz rozmiar tekstu">
        <span class="text-xs font-bold">A-</span>
    </button>
    
    <!-- Rozmiar czcionki -->
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 w-10 text-center" x-text="fontSize + '%'"></span>
    
    <!-- Zwiększ czcionkę -->
    <button 
        type="button"
        @click="fontSize = Math.min(200, fontSize + 10)"
        :disabled="fontSize >= 200"
        class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
        title="Zwiększ czcionkę (WCAG)"
        aria-label="Zwiększ rozmiar tekstu">
        <span class="text-sm font-bold">A+</span>
    </button>
    
    <!-- Reset czcionki -->
    <button 
        type="button"
        @click="fontSize = 100"
        class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors"
        title="Resetuj rozmiar czcionki"
        aria-label="Resetuj rozmiar tekstu do 100%">
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
    </button>
    
    <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-2"></div>
    
    <!-- Wysoki kontrast -->
    <button 
        type="button"
        @click="highContrast = !highContrast"
        :class="highContrast ? 'bg-yellow-400 text-black ring-2 ring-black' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700'"
        class="flex items-center justify-center px-3 h-8 rounded-lg transition-colors font-medium text-xs"
        :title="highContrast ? 'Wyłącz wysoki kontrast' : 'Włącz wysoki kontrast (WCAG)'"
        role="switch"
        aria-checked="false"
        :aria-checked="highContrast.toString()"
        aria-label="Wysoki kontrast">
        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        </svg>
        <span x-text="highContrast ? 'Kontrast: WŁ' : 'Kontrast'"></span>
    </button>
    
    <!-- Czcionka dla dyslektyków -->
    <button 
        type="button"
        @click="dyslexiaFont = !dyslexiaFont"
        :class="dyslexiaFont ? 'bg-blue-500 text-white ring-2 ring-blue-600' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700'"
        class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors font-bold text-sm"
        :title="dyslexiaFont ? 'Wyłącz czcionkę dla dyslektyków' : 'Włącz czcionkę dla dyslektyków'"
        role="switch"
        aria-checked="false"
        :aria-checked="dyslexiaFont.toString()"
        aria-label="Czcionka dla dyslektyków">
        D
    </button>
</div>

<style>
/* Wysoki kontrast - WCAG 2.1 Level AA - zwiększony kontrast bez zmiany całego tła */
html.high-contrast {
    filter: contrast(1.25);
}

html.high-contrast p,
html.high-contrast span,
html.high-contrast label,
html.high-contrast h1,
html.high-contrast h2,
html.high-contrast h3,
html.high-contrast td,
html.high-contrast th {
    color: #000 !important;
}

html.high-contrast a {
    color: #0000cc !important;
    text-decoration: underline !important;
}

html.high-contrast a:hover,
html.high-contrast a:focus {
    color: #000 !important;
    background-color: #ffff00 !important;
    outline: 2px solid #000 !important;
}

html.high-contrast input,
html.high-contrast select,
html.high-contrast textarea {
    background-color: #fff !important;
    color: #000 !important;
    border: 2px solid #000 !important;
}

html.high-contrast input:focus,
html.high-contrast select:focus,
html.high-contrast textarea:focus {
    outline: 3px solid #0000cc !important;
    border-color: #0000cc !important;
}

html.high-contrast input::placeholder {
    color: #555 !important;
}

html.high-contrast button,
html.high-contrast .fi-btn {
    border: 2px solid #000 !important;
}

html.high-contrast .fi-btn-primary,
html.high-contrast button[type="submit"] {
    background-color: #0000cc !important;
    color: #fff !important;
    border: 2px solid #000 !important;
}

html.high-contrast .fi-btn-primary:hover,
html.high-contrast button[type="submit"]:hover {
    background-color: #000 !important;
    color: #ffff00 !important;
}

html.high-contrast table th,
html.high-contrast table td {
    border: 1px solid #000 !important;
}

/* Czcionka dla dyslektyków - WCAG */
html.dyslexia-font,
html.dyslexia-font * {
    font-family: 'Comic Sans MS', 'OpenDyslexic', cursive !important;
    letter-spacing: 0.1em !important;
    line-height: 1.8 !important;
}
</style>

<!-- Toolbar dostępności dla strony logowania -->
<div 
    x-data="{
        fontSize: 100,
        highContrast: false,
        
        init() {
            // Odczytaj z localStorage
            const savedFontSize = localStorage.getItem('accessibility-font-size');
            const savedContrast = localStorage.getItem('accessibility-high-contrast');
            
            if (savedFontSize) this.fontSize = parseInt(savedFontSize);
            if (savedContrast) this.highContrast = savedContrast === 'true';
            
            this.applySettings();
            this.$watch('fontSize', (val) => {
                localStorage.setItem('accessibility-font-size', val);
                this.applySettings();
            });
            this.$watch('highContrast', (val) => {
                localStorage.setItem('accessibility-high-contrast', val);
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
        }
    }"
    class="flex items-center justify-center gap-2 mb-6 p-3 bg-gray-100 rounded-lg border border-gray-200"
    :class="highContrast ? '!bg-black !border-yellow-400' : ''">
    
    <span class="text-xs font-medium text-gray-600 mr-2">Dostępność:</span>
    
    <!-- Zmniejsz czcionkę -->
    <button 
        type="button"
        @click="fontSize = Math.max(80, fontSize - 10)"
        :disabled="fontSize <= 80"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
        title="Zmniejsz czcionkę (WCAG)"
        aria-label="Zmniejsz rozmiar tekstu">
        <span class="text-xs font-bold">A-</span>
    </button>
    
    <!-- Rozmiar czcionki -->
    <span class="text-xs font-medium text-gray-600 w-10 text-center" x-text="fontSize + '%'"></span>
    
    <!-- Zwiększ czcionkę -->
    <button 
        type="button"
        @click="fontSize = Math.min(200, fontSize + 10)"
        :disabled="fontSize >= 200"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
        title="Zwiększ czcionkę (WCAG)"
        aria-label="Zwiększ rozmiar tekstu">
        <span class="text-sm font-bold">A+</span>
    </button>
    
    <!-- Reset czcionki -->
    <button 
        type="button"
        @click="fontSize = 100"
        class="flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
        title="Resetuj rozmiar czcionki"
        aria-label="Resetuj rozmiar tekstu do 100%">
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
        </svg>
    </button>
    
    <div class="w-px h-6 bg-gray-300 mx-1"></div>
    
    <!-- Wysoki kontrast -->
    <button 
        type="button"
        @click="highContrast = !highContrast"
        :class="highContrast ? 'bg-yellow-400 text-black border-black ring-2 ring-black' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'"
        class="flex items-center justify-center px-3 h-8 rounded-lg border transition-colors font-medium text-xs focus:outline-none focus:ring-2 focus:ring-blue-500"
        :title="highContrast ? 'Wyłącz wysoki kontrast' : 'Włącz wysoki kontrast (WCAG)'"
        role="switch"
        :aria-checked="highContrast.toString()"
        aria-label="Wysoki kontrast">
        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        </svg>
        <span x-text="highContrast ? 'WŁ' : 'Kontrast'"></span>
    </button>
</div>

<style>
/* Wysoki kontrast - WCAG 2.1 Level AA - zwiększony kontrast bez zmiany całego tła */
html.high-contrast {
    filter: contrast(1.25);
}

html.high-contrast body {
    background-color: #fff !important;
}

html.high-contrast p,
html.high-contrast span,
html.high-contrast label,
html.high-contrast h1,
html.high-contrast h2,
html.high-contrast h3 {
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
</style>

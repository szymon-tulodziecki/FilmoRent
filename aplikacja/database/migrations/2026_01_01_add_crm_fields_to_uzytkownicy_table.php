<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja dodająca pola CRM do tabeli użytkowników.
     * Obsługuje zarówno klientów indywidualnych jak i biznesowych.
     */
    public function up(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            // Typ klienta: 'indywidualny' lub 'biznesowy'
            $table->enum('typ_klienta', ['indywidualny', 'biznesowy'])->default('indywidualny')->after('telefon');
            
            // Dane osobowe
            $table->string('pesel', 11)->nullable()->after('typ_klienta');
            
            // Dane biznesowe
            $table->string('nazwa_firmy', 255)->nullable()->after('pesel');
            $table->string('nip', 10)->nullable()->unique()->after('nazwa_firmy');
            $table->string('regon', 14)->nullable()->after('nip');
            
            // Dane kontaktowe dla biznesu
            $table->string('osoba_kontaktowa', 255)->nullable()->after('regon');
            $table->string('stanowisko', 100)->nullable()->after('osoba_kontaktowa');
            
            // Notatki CRM
            $table->text('notatki_crm')->nullable()->after('stanowisko');
            
            // Status klienta
            $table->enum('status_klienta', ['aktywny', 'wstrzymany', 'zablokowany'])->default('aktywny')->after('notatki_crm');
            
            // Indeksy
            $table->index('typ_klienta');
            $table->index('status_klienta');
            $table->index('pesel');
        });
    }

    public function down(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->dropIndex(['typ_klienta']);
            $table->dropIndex(['status_klienta']);
            $table->dropIndex(['pesel']);
            $table->dropUnique(['nip']);
            
            $table->dropColumn([
                'typ_klienta',
                'pesel',
                'nazwa_firmy',
                'nip',
                'regon',
                'osoba_kontaktowa',
                'stanowisko',
                'notatki_crm',
                'status_klienta',
            ]);
        });
    }
};

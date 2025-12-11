<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli wypożyczeń - nagłówek transakcji.
     */
    public function up(): void
    {
        Schema::create('wypozyczenia', function (Blueprint $table) {
            $table->id();
            $table->string('numer_zamowienia', 50)->unique();
            $table->foreignId('uzytkownik_id')->constrained('uzytkownicy');
            $table->foreignId('pracownik_id')->nullable()->constrained('uzytkownicy');
            $table->foreignId('status_id')->constrained('statusy_wypozyczenia');
            
            $table->dateTime('data_rezerwacji');
            $table->dateTime('data_odbioru');
            $table->dateTime('data_zwrotu');
            $table->dateTime('faktyczna_data_zwrotu')->nullable();
            
            $table->decimal('suma_calkowita', 10, 2);
            $table->text('uwagi')->nullable();
            
            $table->timestamp('utworzono_data')->useCurrent();
            $table->timestamp('zaktualizowano_data')->nullable()->useCurrentOnUpdate();
            
            $table->index('uzytkownik_id');
            $table->index('pracownik_id');
            $table->index('status_id');
            $table->index('data_odbioru');
            $table->index('data_zwrotu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wypozyczenia');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli sprzętu - serce systemu FilmoRent.
     */
    public function up(): void
    {
        Schema::create('sprzet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategoria_id')->constrained('kategorie');
            $table->foreignId('producent_id')->constrained('producenci');
            $table->string('nazwa', 255);
            $table->string('numer_seryjny', 100)->unique();
            $table->text('opis')->nullable();
            $table->decimal('cena_doba', 10, 2);
            $table->decimal('kaucja', 10, 2);
            $table->decimal('wartosc_rynkowa', 10, 2);
            $table->enum('status_sprzetu', ['dostepny', 'w_serwisie', 'wycofany', 'zaginiony'])
                  ->default('dostepny');
            
            $table->timestamp('utworzono_data')->useCurrent();
            $table->timestamp('zaktualizowano_data')->nullable()->useCurrentOnUpdate();
            
            $table->index('kategoria_id');
            $table->index('producent_id');
            $table->index('numer_seryjny');
            $table->index('status_sprzetu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sprzet');
    }
};

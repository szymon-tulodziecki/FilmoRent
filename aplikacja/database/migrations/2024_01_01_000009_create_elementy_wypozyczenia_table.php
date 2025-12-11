<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli elementów wypożyczenia (Pivot Table).
     */
    public function up(): void
    {
        Schema::create('elementy_wypozyczenia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wypozyczenie_id')->constrained('wypozyczenia')->onDelete('cascade');
            $table->foreignId('sprzet_id')->constrained('sprzet');
            
            $table->decimal('cena_netto_snapshot', 10, 2);
            $table->integer('rabat_procent')->default(0);
            
            $table->index('wypozyczenie_id');
            $table->index('sprzet_id');
            $table->unique(['wypozyczenie_id', 'sprzet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elementy_wypozyczenia');
    }
};

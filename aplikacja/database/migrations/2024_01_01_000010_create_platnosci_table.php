<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli płatności.
     */
    public function up(): void
    {
        Schema::create('platnosci', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wypozyczenie_id')->constrained('wypozyczenia');
            $table->decimal('kwota', 10, 2);
            $table->enum('typ', ['zaliczka', 'oplata_koncowa', 'kaucja', 'zwrot_kaucji', 'kara']);
            $table->enum('metoda', ['przelew', 'gotowka', 'karta', 'blik']);
            $table->enum('status', ['oczekujaca', 'zrealizowana', 'odrzucona']);
            $table->string('zewnetrzne_id', 255)->nullable();
            
            $table->timestamp('utworzono_data')->useCurrent();
            
            $table->index('wypozyczenie_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platnosci');
    }
};

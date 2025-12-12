<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli statusów wypożyczenia - słownik stanów.
     */
    public function up(): void
    {
        Schema::create('statusy_wypozyczenia', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 50);
            $table->string('klucz', 50)->unique();
            $table->string('kolor', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statusy_wypozyczenia');
    }
};

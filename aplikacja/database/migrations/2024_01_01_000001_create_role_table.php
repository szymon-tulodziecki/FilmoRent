<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli ról użytkowników systemu FilmoRent.
     * Tabela przechowuje definicje ról (Admin, Pracownik, Klient).
     */
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 50);           // Wyświetlana nazwa roli
            $table->string('klucz', 50)->unique(); // Identyfikator systemowy (admin, pracownik, klient)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};

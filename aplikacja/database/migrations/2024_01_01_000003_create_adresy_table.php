<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli adresów użytkowników.
     */
    public function up(): void
    {
        Schema::create('adresy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uzytkownik_id')->constrained('uzytkownicy')->onDelete('cascade');
            $table->string('ulica', 255);
            $table->string('miasto', 100);
            $table->string('kod_pocztowy', 20);
            $table->enum('typ', ['rozliczeniowy', 'dostawy']);
            
            $table->index('uzytkownik_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adresy');
    }
};

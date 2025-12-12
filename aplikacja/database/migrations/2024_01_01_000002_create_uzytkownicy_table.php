<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli użytkowników systemu FilmoRent.
     */
    public function up(): void
    {
        Schema::create('uzytkownicy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rola_id')->constrained('role');
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('email')->unique();
            $table->string('haslo');
            $table->string('telefon', 20)->nullable();
            $table->timestamp('zweryfikowany_email_data')->nullable();
            $table->rememberToken();
            
            // Polskie timestampy
            $table->timestamp('utworzono_data')->useCurrent();
            $table->timestamp('zaktualizowano_data')->nullable()->useCurrentOnUpdate();
            
            $table->index('email');
            $table->index('rola_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uzytkownicy');
    }
};

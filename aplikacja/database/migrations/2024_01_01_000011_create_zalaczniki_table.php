<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli załączników z relacją polimorficzną.
     */
    public function up(): void
    {
        Schema::create('zalaczniki', function (Blueprint $table) {
            $table->id();
            $table->string('sciezka', 255);
            $table->string('nazwa_oryginalna', 255);
            $table->string('typ_mime', 50);
            $table->string('opis_alternatywny', 255)->nullable(); // Alt text dla WCAG
            
            // Relacja Polimorficzna
            $table->morphs('model');
            
            $table->timestamp('utworzono_data')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zalaczniki');
    }
};

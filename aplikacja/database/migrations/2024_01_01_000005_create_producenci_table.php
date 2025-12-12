<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli producentów sprzętu.
     */
    public function up(): void
    {
        Schema::create('producenci', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa', 100);
            $table->text('opis')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producenci');
    }
};

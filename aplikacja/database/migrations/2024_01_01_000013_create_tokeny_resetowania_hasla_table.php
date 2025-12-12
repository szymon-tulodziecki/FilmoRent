<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli tokenów resetowania hasła.
     */
    public function up(): void
    {
        Schema::create('tokeny_resetowania_hasla', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('utworzono_data')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokeny_resetowania_hasla');
    }
};

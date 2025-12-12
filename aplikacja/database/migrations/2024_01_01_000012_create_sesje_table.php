<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migracja tabeli sesji użytkowników.
     */
    public function up(): void
    {
        Schema::create('sesje', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('uzytkownik_id')->nullable()->index();
            $table->string('adres_ip', 45)->nullable();
            $table->text('agent_przegladarki')->nullable();
            $table->longText('dane');
            $table->integer('ostatnia_aktywnosc')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesje');
    }
};

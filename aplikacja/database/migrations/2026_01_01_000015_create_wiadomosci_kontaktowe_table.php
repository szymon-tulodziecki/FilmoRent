<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiadomosci_kontaktowe', function (Blueprint $table) {
            $table->id();
            $table->string('imie_nazwisko', 255);
            $table->string('email', 255);
            $table->string('temat', 255);
            $table->text('wiadomosc');
            $table->enum('status', ['nowa', 'przeczytana', 'odpowiedziana'])->default('nowa');
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wiadomosci_kontaktowe');
    }
};

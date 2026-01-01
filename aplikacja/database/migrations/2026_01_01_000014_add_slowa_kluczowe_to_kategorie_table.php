<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategorie', function (Blueprint $table) {
            $table->text('slowa_kluczowe')->nullable()->after('slug')->comment('Słowa kluczowe do wyszukiwania, oddzielone przecinkami');
        });
    }

    public function down(): void
    {
        Schema::table('kategorie', function (Blueprint $table) {
            $table->dropColumn('slowa_kluczowe');
        });
    }
};

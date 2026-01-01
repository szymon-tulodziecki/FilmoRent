<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Make nazwisko nullable to support simplified registration form.
     * Users will fill in their nazwisko (last name) in account settings after registration.
     */
    public function up(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->string('nazwisko', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('uzytkownicy', function (Blueprint $table) {
            $table->string('nazwisko', 100)->nullable(false)->change();
        });
    }
};

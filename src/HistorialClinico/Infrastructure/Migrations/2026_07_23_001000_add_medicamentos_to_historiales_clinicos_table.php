<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            $table->json('medicamentos')->nullable()->after('diagnostico');
        });
    }

    public function down(): void
    {
        Schema::table('historiales_clinicos', function (Blueprint $table) {
            $table->dropColumn('medicamentos');
        });
    }
};

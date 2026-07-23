<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('medico_id');
            $table->string('dia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('intervalo_minutos')->default(30);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('cascade');
            $table->unique(['medico_id', 'dia', 'hora_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historiales_clinicos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cita_id');
            $table->uuid('paciente_id');
            $table->uuid('medico_id');
            $table->text('motivo_consulta');
            $table->text('observaciones_medicas')->nullable();
            $table->text('diagnostico');
            $table->text('indicaciones')->nullable();
            $table->dateTime('fecha_atencion');
            $table->timestamps();

            $table->foreign('cita_id')->references('id')->on('citas')->onDelete('restrict');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('restrict');
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historiales_clinicos');
    }
};

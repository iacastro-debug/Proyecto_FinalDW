<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluaciones_ia', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('paciente_id');
            $table->integer('edad')->nullable();
            $table->string('genero')->nullable();
            $table->text('sintomas_principales');
            $table->string('duracion_sintomas')->nullable();
            $table->string('nivel_dolor')->nullable();
            $table->boolean('fiebre')->default(false);
            $table->boolean('dificultad_respirar')->default(false);
            $table->boolean('dolor_pecho')->default(false);
            $table->text('antecedentes')->nullable();
            $table->string('urgencia_percibida')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('especialidad_sugerida')->nullable();
            $table->string('prioridad')->nullable();
            $table->text('motivo')->nullable();
            $table->text('advertencia')->nullable();
            $table->longText('respuesta_raw')->nullable();
            $table->enum('estado', ['generada', 'usada_para_cita', 'revisada_medico', 'cerrada', 'anulada'])->default('generada');
            $table->boolean('modo_simulado')->default(false);
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluaciones_ia');
    }
};

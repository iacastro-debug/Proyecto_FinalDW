<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('paciente_id');
            $table->uuid('medico_id');
            $table->uuid('especialidad_id');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->enum('estado', ['pendiente', 'confirmada', 'atendida', 'cancelada', 'reprogramada', 'no_asistio'])->default('pendiente');
            $table->text('motivo_consulta')->nullable();
            $table->uuid('evaluacion_ia_id')->nullable();
            $table->text('observaciones')->nullable();
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('restrict');
            $table->foreign('medico_id')->references('id')->on('medicos')->onDelete('restrict');
            $table->foreign('especialidad_id')->references('id')->on('especialidades')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

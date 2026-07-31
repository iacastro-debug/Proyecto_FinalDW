<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('nombres')->nullable()->after('user_id');
            $table->string('apellidos')->nullable()->after('nombres');
            $table->string('email')->nullable()->after('apellidos');
            $table->string('grupo_sanguineo')->nullable()->after('genero');
            $table->text('alergias')->nullable()->after('grupo_sanguineo');
            $table->text('enfermedades_cronicas')->nullable()->after('alergias');
            $table->text('medicamentos_actuales')->nullable()->after('enfermedades_cronicas');
            $table->string('contacto_emergencia_nombre')->nullable()->after('medicamentos_actuales');
            $table->string('contacto_emergencia_telefono')->nullable()->after('contacto_emergencia_nombre');
            $table->string('seguro_medico')->nullable()->after('contacto_emergencia_telefono');
        });

        DB::statement("UPDATE pacientes p SET nombres = u.name, apellidos = '', email = u.email FROM users u WHERE u.id = p.user_id");
    }

    public function down(): void
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn([
                'nombres',
                'apellidos',
                'email',
                'grupo_sanguineo',
                'alergias',
                'enfermedades_cronicas',
                'medicamentos_actuales',
                'contacto_emergencia_nombre',
                'contacto_emergencia_telefono',
                'seguro_medico',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['reservado', 'libre'])->default('reservado');
            $table->string('comentario')->nullable();

            // --- Claves Foráneas ---
            // ¡IMPORTANTE! Descomentar esta línea para crear la columna user_id
            $table->foreignId('user_id') // Esta creará la columna 'user_id'
                  ->constrained() // Asume que la tabla de usuarios es 'users'
                  ->onDelete('cascade');

            // Clave foránea del TRATAMIENTO asociado al turno
            $table->foreignId('tratamientos_id')
                  ->constrained('tratamientos') // Asume que la tabla es 'tratamientos'
                  ->onDelete('cascade');

            // Clave foránea del MÉDICO asignado al turno
            $table->foreignId('medico_id')
                  ->constrained('medicos') // Asume que la tabla es 'medicos'
                  ->onDelete('cascade');

            // --- Campos de Fecha y Hora del Turno (¡cruciales!) ---
            $table->date('fecha');       // La fecha específica del turno (ej. '2025-07-06')
            $table->time('hora_inicio'); // La hora de inicio del turno (ej. '09:00:00')
            $table->time('hora_fin');    // La hora de fin del turno (ej. '09:30:00')

            $table->timestamps();

    
            $table->unique(['medico_id', 'fecha', 'hora_inicio']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turnos'); // Es buena práctica incluir esto para el rollback
    }
};
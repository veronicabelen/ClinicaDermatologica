<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importar para las relaciones belongsTo

class Turno extends Model
{
    protected $table = 'turnos';

    // ¡IMPORTANTE! Actualiza el array $fillable para incluir todas las columnas
    // que se usan para crear o actualizar un turno
    protected $fillable = [
        'estado',
        'comentario',
        'fecha', // Si usas una sola columna 'fecha' para el día del turno
        'hora_inicio',
        'hora_fin',
        'user_id',        // Para el paciente que reserva el turno
        'medico_id',      // Para el médico asignado al turno
        'tratamientos_id',// Para el tratamiento asociado al turno
    ];

    // Opcional: Si quieres que Laravel maneje las fechas como objetos Carbon
    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime', // Si la guardas como 'Y-m-d H:i:s'
        'hora_fin' => 'datetime',    // Si la guardas como 'Y-m-d H:i:s'
    ];


    // --- Definir las relaciones inversas ---

    /**
     * Obtiene el usuario (paciente) que reservó este turno.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene el médico asignado a este turno.
     *
     * @return BelongsTo
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'medico_id'); // Asume que tienes un modelo Medico
    }

    /**
     * Obtiene el tratamiento asociado a este turno.
     *
     * @return BelongsTo
     */
    public function tratamiento(): BelongsTo
    {
        return $this->belongsTo(Tratamiento::class, 'tratamientos_id'); // Asume que tienes un modelo Tratamiento
    }
}
<?php

namespace App\Models;

use App\Models\Medico;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tratamiento extends Model
{
    protected $table = 'tratamientos';

    // Se actualizan los campos fillable para que coincidan con la migración y el controlador
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
    ];

    
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }
}


<?php

namespace App\Models;

// Importaciones necesarias para las relaciones
use Illuminate\Database\Eloquent\Relations\HasMany; // ¡MUY IMPORTANTE esta línea!
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Si usas tratamientosReservados()

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // --- Funciones para verificar el rol del usuario ---

    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    // Cambiado de isInstructor a isMedico
    public function isMedico(): bool
    {
        return $this->rol === 'medico';
    }

    // Cambiado de isEstudiante a isPaciente
    public function isPaciente(): bool
    {
        return $this->rol === 'paciente';
    }

    // --- Relaciones ---

    /**
     * Obtiene los turnos que este usuario (como paciente) ha reservado.
     *
     * Asume que la tabla 'turnos' tiene una columna 'user_id' que hace referencia al paciente.
     *
     * @return HasMany
     */
    public function turnos(): HasMany // <-- ESTE ES EL MÉTODO QUE BUSCA
    {
        return $this->hasMany(Turno::class, 'user_id');
    }

    /**
     * Obtiene los tratamientos que este usuario (como paciente) ha reservado
     * a través de sus turnos.
     *
     * Utiliza la tabla 'turnos' como tabla pivote entre 'users' y 'tratamientos'.
     *
     * @return BelongsToMany
     */
    public function tratamientosReservados(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\Tratamiento::class,
            'turnos',            // Nombre de la tabla pivote
            'user_id',           // Clave foránea del modelo User en la tabla pivote ('turnos')
            'tratamientos_id'    // Clave foránea del modelo Tratamiento en la tabla pivote ('turnos')
        );
    }
}
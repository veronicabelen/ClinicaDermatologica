<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turno;       // Usaremos el modelo Turno
use App\Models\Medico;      // Necesitamos el modelo Medico para cargar sus datos
use App\Models\Tratamiento; // Necesitamos el modelo Tratamiento para cargar sus datos
use Illuminate\Support\Facades\Auth;

class DashboardTurnosDisponibles extends Component
{
    public $turnosDisponibles = []; // Lista de turnos que están 'libres' y pueden ser reservados
    public $misTurnos = [];         // Lista de turnos que el usuario autenticado ya reservó

    public function mount()
    {
        // Al iniciar el componente, actualizamos ambas listas
        $this->actualizarListas();
    }

    /**
     * Permite al usuario reservar un turno disponible.
     *
     * @param int $turnoId El ID del turno específico (slot) que el usuario quiere reservar.
     */
    public function reservarTurno($turnoId)
    {
        $user = Auth::user();
        if (!$user) {
            session()->flash('error', 'Debes iniciar sesión para reservar un turno.');
            return;
        }

        // 1. Buscar el turno específico por su ID
        $turno = Turno::find($turnoId);

        // 2. Validaciones iniciales
        if (!$turno) {
            session()->flash('error', 'El turno seleccionado no fue encontrado.');
            return;
        }

        if ($turno->estado !== 'libre') {
            session()->flash('error', 'Este turno ya no está disponible para ser reservado.');
            return;
        }

        


        // 4. Asignar el turno al usuario y cambiar su estado
        $turno->user_id = $user->id;
        $turno->estado = 'reservado'; // Cambiar a 'reservado'
        $turno->save();

        // 5. Mensaje de éxito y actualización de las listas
        session()->flash('success', 'Turno reservado correctamente.');
        $this->actualizarListas();
    }

    /**
     * Actualiza las listas de turnos disponibles y los turnos del usuario.
     */
    public function actualizarListas()
    {
        $user = Auth::user();

        // Obtener los turnos que el usuario autenticado ha reservado
        // Usamos eager loading (.with(['medico', 'tratamiento'])) para cargar la información
        // del médico y el tratamiento en una sola consulta, optimizando el rendimiento.
       
    }

    public function render()
    {
        return view('livewire.dashboard-turnos-disponibles', [
            'turnosDisponibles' => $this->turnosDisponibles,
            'misTurnos' => $this->misTurnos,
        ]);
    }
}
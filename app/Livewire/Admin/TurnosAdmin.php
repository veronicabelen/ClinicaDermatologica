<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Turno; // ¡Importante! Cambiamos de Taller a Turno
use App\Models\Tratamiento; // Posiblemente necesario para relacionar turnos con tratamientos
use App\Models\Medico; // Posiblemente necesario para relacionar turnos con médicos

class TurnosAdmin extends Component
{
    // Propiedades del formulario para crear/editar un turno
    // Se asume que un turno representa una franja horaria disponible para un tratamiento con un médico
    public $estado; // Podría ser 'disponible', 'reservado', 'cancelado'
    public $comentario;
    public $fecha; // En lugar de fecha_inicio/fin, si un turno es para un día específico
    public $hora_inicio;
    public $hora_fin;
    public $medico_id; // Clave foránea para el médico que ofrece el turno
    public $tratamiento_id; // Clave foránea para el tratamiento asociado al turno
    public $turno_id; // ID del turno cuando se está editando
    public $editMode = false;

    // Puedes añadir propiedades para filtros o búsqueda si es necesario
    public $filter_medico_id;
    public $filter_tratamiento_id;

    // Reglas de validación para la creación/actualización de turnos
    protected $rules = [
        'estado' => 'required|in:reservado,libre', // Asume que 'estado' es un enum con estos valores
        'comentario' => 'nullable|string|max:500',
        'fecha' => 'required|date|after_or_equal:today', // La fecha no puede ser anterior a hoy
        'hora_inicio' => 'required|date_format:H:i', // Formato HH:MM
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // Debe ser posterior a hora_inicio
        'medico_id' => 'required|exists:medicos,id', // Debe existir en la tabla 'medicos'
        'tratamiento_id' => 'required|exists:tratamientos,id', // Debe existir en la tabla 'tratamientos'
    ];

    // Propiedades computadas o escuchadas si es necesario
    // protected $listeners = ['refreshTurnos' => '$refresh'];

    /**
     * Inicializa las propiedades si es necesario.
     * Se puede usar mount() si se carga data inicial al montar el componente.
     */
    // public function mount()
    // {
    //     $this->estado = 'libre'; // Estado por defecto para nuevos turnos
    // }

    /**
     * Crea un nuevo turno.
     *
     * @return void
     */
    public function crearTurno()
    {
        $this->validate();

        Turno::create([
            'estado' => $this->estado,
            'comentario' => $this->comentario,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'medico_id' => $this->medico_id,
            'tratamiento_id' => $this->tratamiento_id,
            // user_id no se incluye aquí porque este es para CREAR turnos disponibles por el admin
            // el user_id se asignaría cuando un usuario "reserva" un turno
        ]);

        $this->resetForm();
        session()->flash('success', 'Turno creado correctamente.');
    }

    /**
     * Prepara el formulario para editar un turno existente.
     *
     * @param int $id El ID del turno a editar.
     * @return void
     */
    public function editarTurno($id)
    {
        $turno = Turno::findOrFail($id);

        $this->turno_id = $turno->id;
        $this->estado = $turno->estado;
        $this->comentario = $turno->comentario;
        $this->fecha = $turno->fecha;
        $this->hora_inicio = $turno->hora_inicio;
        $this->hora_fin = $turno->hora_fin;
        $this->medico_id = $turno->medico_id;
        $this->tratamiento_id = $turno->tratamiento_id;
        $this->editMode = true;
    }

    /**
     * Actualiza un turno existente en la base de datos.
     *
     * @return void
     */
    public function actualizarTurno()
    {
        $this->validate();

        $turno = Turno::findOrFail($this->turno_id);
        $turno->update([
            'estado' => $this->estado,
            'comentario' => $this->comentario,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'medico_id' => $this->medico_id,
            'tratamiento_id' => $this->tratamiento_id,
        ]);

        $this->resetForm();
        session()->flash('success', 'Turno actualizado correctamente.');
    }

    /**
     * Elimina un turno de la base de datos.
     *
     * @param int $id El ID del turno a eliminar.
     * @return void
     */
    public function eliminarTurno($id)
    {
        Turno::destroy($id);
        session()->flash('success', 'Turno eliminado correctamente.');
    }

    /**
     * Cancela el modo de edición y reinicia el formulario.
     *
     * @return void
     */
    public function cancelarEdicion()
    {
        $this->resetForm();
    }

    /**
     * Reinicia todas las propiedades del formulario y el modo de edición.
     *
     * @return void
     */
    private function resetForm()
    {
        $this->reset([
            'estado',
            'comentario',
            'fecha',
            'hora_inicio',
            'hora_fin',
            'medico_id',
            'tratamiento_id',
            'turno_id',
            'editMode'
        ]);
    }

    /**
     * Renderiza la vista del componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtener todos los turnos, posiblemente con filtros
        $query = Turno::latest();

        if ($this->filter_medico_id) {
            $query->where('medico_id', $this->filter_medico_id);
        }

        if ($this->filter_tratamiento_id) {
            $query->where('tratamiento_id', $this->filter_tratamiento_id);
        }

        $turnos = $query->get();

        // Necesitas cargar médicos y tratamientos para los selectores en el formulario y filtros
        $medicos = Medico::all();
        $tratamientos = Tratamiento::all();

        return view('livewire.admin.turnos-admin', compact('turnos', 'medicos', 'tratamientos'));
    }
}
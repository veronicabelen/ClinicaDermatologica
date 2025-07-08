<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Turno; // Cambiamos de Taller a Turno
use App\Models\User;
use App\Models\Medico;
use App\Models\Tratamiento;
use Illuminate\Validation\ValidationException;

class MisTurnosController extends Controller
{
    /**
     * Muestra la lista de turnos del usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Usar la relación correcta 'turnos' en el modelo User
        // Asegúrate de que el modelo User tiene un método 'turnos()' que define la relación
        $turnos = Auth::user()->turnos()->with(['tratamiento', 'medico'])->get(); // Asume que un usuario puede tener muchos turnos
       //var_dump($turnos);die(); 
        return view('mis-turnos', compact('turnos')); // Cambiamos a 'mis-turnos' para la vista
    }

  
     public function ReservarTurno ()
    {
         $medicos = Medico::all();
        $tratamientos = Tratamiento::all();

        return view('reservar-turno', compact('medicos', 'tratamientos'));
    }

    /**
     * Almacena un nuevo turno reservado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Reglas de validación para los campos del formulario
            $validatedData = $request->validate([
                'medico_id' => 'required|exists:medicos,id',
                'tratamientos_id' => 'required|exists:tratamientos,id',
                'fecha' => 'required|date|after_or_equal:today', // La fecha no puede ser anterior a hoy
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // La hora de fin debe ser posterior a la de inicio
                'comentario' => 'nullable|string|max:500',
            ]);

            $user = Auth::user(); // Obtener el usuario autenticado

            // Verificar si el turno ya está ocupado (por el mismo médico en la misma fecha y hora)
            $existingTurno = Turno::where('medico_id', $validatedData['medico_id'])
                                  ->where('fecha', $validatedData['fecha'])
                                  ->where('hora_inicio', $validatedData['hora_inicio'])
                                  ->where('estado', 'reservado') // Solo verificar si ya está reservado
                                  ->first();

            if ($existingTurno) {
                return redirect()->back()->withInput()->with('error', 'Este horario ya está ocupado por otro paciente o no está disponible.');
            }

            // Crear el nuevo turno
            Turno::create([
                'user_id' => $user->id, // Asignar el ID del usuario autenticado
                'medico_id' => $validatedData['medico_id'],
                'tratamientos_id' => $validatedData['tratamientos_id'],
                'fecha' => $validatedData['fecha'],
                'hora_inicio' => $validatedData['hora_inicio'],
                'hora_fin' => $validatedData['hora_fin'],
                'comentario' => $validatedData['comentario'],
                'estado' => 'reservado', // El estado por defecto para un turno que se acaba de reservar
            ]);

            return redirect()->route('mis-turnos')->with('success', 'Turno reservado exitosamente.');

        } catch (ValidationException $e) {
            // Redirigir de vuelta con los errores de validación y los datos ingresados
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Capturar cualquier otra excepción inesperada
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al intentar reservar el turno. Por favor, inténtalo de nuevo. ' . $e->getMessage());
        }
    }

    /**
     * Elimina un turno específico de la base de datos.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Turno $turno)
    {
        // Opcional: Puedes añadir una política de autorización aquí
        // para asegurarte de que solo el usuario propietario o un admin pueda eliminar el turno.
        // Por ejemplo: $this->authorize('delete', $turno);

        try {
            $turno->delete(); // Elimina el turno de la base de datos
            return redirect()->route('mis-turnos')->with('success', 'Turno eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el turno: ' . $e->getMessage());
        }
    }
    
}


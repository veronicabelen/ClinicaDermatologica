<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamiento; // Importa tu modelo Tratamiento (asumiendo que el modelo se llamará Tratamiento)
use Illuminate\Validation\ValidationException; // Para manejar errores de validación

class TratamientoController extends Controller // Renombrado de TratamientoDisponibleController a TratamientoController
{
    /**
     * Muestra una lista de todos los tratamientos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene todos los tratamientos de la base de datos
        $tratamientos = Tratamiento::all();
        // Pasa los tratamientos a la vista 'tratamientos/index.blade.php'
        return view('tratamientos-disponibles', compact('tratamientos'));
    }

    /**
     * Muestra el formulario para crear un nuevo tratamiento.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Muestra el formulario 'tratamientos/create.blade.php'
        return view('tratamientos.create');
    }

    /**
     * Almacena un nuevo tratamiento en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Valida los datos del formulario según los campos de la migración 'tratamientos'
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string', // La migración no lo marca como nullable
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio', // La fecha de fin debe ser igual o posterior a la de inicio
                'hora_inicio' => 'required|date_format:H:i', // Formato HH:MM
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio', // La hora de fin debe ser posterior a la de inicio
            ]);

            // Crea y guarda el nuevo tratamiento
            Tratamiento::create($request->all());

            // Redirige a la lista de tratamientos con un mensaje de éxito
            return redirect()->route('tratamientos.index')->with('success', 'Tratamiento creado exitosamente.');
        } catch (ValidationException $e) {
            // Si hay errores de validación, redirige de vuelta con los errores y los datos ingresados
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Muestra los detalles de un tratamiento específico.
     *
     * @param  \App\Models\Tratamiento  $tratamiento
     * @return \Illuminate\View\View
     */
    public function show(Tratamiento $tratamiento)
    {
        // Muestra los detalles de un tratamiento en 'tratamientos/show.blade.php'
        return view('tratamientos.show', compact('tratamiento'));
    }

    /**
     * Muestra el formulario para editar un tratamiento existente.
     *
     * @param  \App\Models\Tratamiento  $tratamiento
     * @return \Illuminate\View\View
     */
    public function edit(Tratamiento $tratamiento)
    {
        // Muestra el formulario de edición 'tratamientos/edit.blade.php'
        return view('tratamientos.edit', compact('tratamiento'));
    }

    /**
     * Actualiza un tratamiento existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tratamiento  $tratamiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tratamiento $tratamiento)
    {
        try {
            // Valida los datos del formulario según los campos de la migración 'tratamientos'
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            ]);

            // Actualiza el tratamiento
            $tratamiento->update($request->all());

            // Redirige a la lista de tratamientos con un mensaje de éxito
            return redirect()->route('tratamientos.index')->with('success', 'Tratamiento actualizado exitosamente.');
        } catch (ValidationException $e) {
            // Si hay errores de validación, redirige de vuelta con los errores y los datos ingresados
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Elimina un tratamiento de la base de datos.
     *
     * @param  \App\Models\Tratamiento  $tratamiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tratamiento $tratamiento)
    {
        // Elimina el tratamiento
        $tratamiento->delete();

        // Redirige a la lista de tratamientos con un mensaje de éxito
        return redirect()->route('tratamientos.index')->with('success', 'Tratamiento eliminado exitosamente.');
    }
}

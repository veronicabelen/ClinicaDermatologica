<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico; // Importa tu modelo Medico
use Illuminate\Validation\ValidationException; // Para manejar errores de validación, opcional pero útil

class MedicoController extends Controller
{
    
    public function index()
    {
      
    $medicos = Medico::all(); // Obtiene todos los médicos de la base de datos
    return view('medicos-registrados', compact('medicos')); // Pasa los médicos a la vista 'medicos/index.blade.php'
    }

    
    public function create()
    {
        return view('medicos.create'); // Muestra el formulario 'medicos/create.blade.php'
    }


    public function store(Request $request)
    {
        try {
            // Valida los datos del formulario
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:255',
                'professional_license' => 'required|string|unique:medicos,professional_license|max:255', // Única en la tabla 'medicos'
                'description' => 'nullable|string',
            ]);

            // Crea y guarda el nuevo médico
            Medico::create($request->all());

            return redirect()->route('medicos.index')->with('success', 'Médico creado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    
    public function show(Medico $medico) // Inyección de modelo para obtener el médico automáticamente
    {
        return view('medicos-registrados', compact('medico')); // Muestra los detalles de un médico en 'medicos/show.blade.php'
    }

    /**
     * Muestra el formulario para editar un médico existente.
     *
     * @param  \App\Models\Medico  $medico
     * @return \Illuminate\View\View
     */
    public function edit(Medico $medico)
    {
        return view('medicos.edit', compact('medico')); // Muestra el formulario de edición 'medicos/edit.blade.php'
    }

   
    public function update(Request $request, Medico $medico)
    {
        try {
            // Valida los datos del formulario
            $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'title' => 'nullable|string|max:255',
                // La licencia profesional debe ser única, ignorando la del médico actual
                'professional_license' => 'required|string|unique:medicos,professional_license,' . $medico->id . '|max:255',
                'description' => 'nullable|string',
            ]);

            // Actualiza el médico
            $medico->update($request->all());

            return redirect()->route('medicos.index')->with('success', 'Médico actualizado exitosamente.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    
    public function destroy(Medico $medico)
    {
        $medico->delete(); // Elimina el médico

        return redirect()->route('medicos.index')->with('success', 'Médico eliminado exitosamente.');
    }
}
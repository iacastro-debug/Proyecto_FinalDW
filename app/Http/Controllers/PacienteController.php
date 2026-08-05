<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        return Inertia::render('Paciente/index', [
            'pacientes' => Paciente::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Paciente/create');
    }

    public function store(Request $request)
    {
        // Validar que los campos principales no vengan vacíos
        $validated = $request->validate([
            'email' => 'required|email',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'telefono' => 'required',
        ]);

        // Guardar en la base de datos con todos los campos enviados
        Paciente::create($request->all());

        // Redirigir a la vista de la tabla
        return redirect()->route('pacientes.index');
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return redirect()->route('pacientes.index');
    }
}
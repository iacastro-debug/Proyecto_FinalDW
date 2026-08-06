<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicoController extends Controller
{
    public function index()
    {
        return Inertia::render('Medicos/Index', [
            'medicos' => Medico::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Medicos/Create', [
            'especialidades' => Especialidad::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validamos lo que llega desde Vue
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:medicos,email',
            'especialidad'    => 'required|string',
            'numero_registro' => 'nullable|string|max:100',
            'telefono'        => 'required|string|max:20',
            'estado'          => 'required|in:activo,inactivo',
        ]);

        // Separamos el campo "name" en "nombre" y "apellido"
        $partesNombre = explode(' ', trim($request->name), 2);
        $nombre = $partesNombre[0];
        $apellido = $partesNombre[1] ?? '';

        // Creamos el médico asignando el resultado a la variable $medico
        $medico = Medico::create([
            'nombre'          => $nombre,
            'apellido'        => $apellido,
            'especialidad'    => $request->especialidad,
            'email'           => $request->email,
            'telefono'        => $request->telefono,
            'numero_registro' => $request->numero_registro,
            'estado'          => $request->estado,
        ]);

        // Asignamos el rol de Spatie al nuevo registro
        $medico->assignRole('Medico');

        return redirect()->route('medicos.index')->with('success', 'Médico registrado exitosamente.');
    }
}
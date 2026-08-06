<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index()
    {
        return Inertia::render('Historial/Index', [
            'historiales' => [] // Aquí pasarás los registros de la base de datos más adelante
        ]);
    }
}
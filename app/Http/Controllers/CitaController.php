<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CitaController extends Controller
{
    public function create()
    {
        return Inertia::render('Citas/Create'); // O la ruta de tu componente Vue
    }
}
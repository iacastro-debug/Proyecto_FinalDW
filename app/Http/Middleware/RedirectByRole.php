<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('Administrador')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('Recepcionista')) {
                return redirect()->route('recepcion.citas.index');
            }

            if ($user->hasRole('Medico')) {
                return redirect()->route('medico.agenda');
            }

            if ($user->hasRole('Paciente')) {
                return redirect()->route('paciente.citas.index');
            }
        }

        return $next($request);
    }
}
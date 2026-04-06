<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Revisamos el rol del usuario que ya inició sesión
        $rolUsuario = Auth::user()->rol;

        // Si su rol no está en la lista de permitidos, le lanzamos un error 403
        if (!in_array($rolUsuario, $roles)) {
            abort(403, 'ACCESO DENEGADO: Tu rol de ' . $rolUsuario . ' no tiene permisos para esta zona.');
        }

        return $next($request);
    }
}
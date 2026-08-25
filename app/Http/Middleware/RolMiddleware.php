<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (auth()->user()->rol !== $rol) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
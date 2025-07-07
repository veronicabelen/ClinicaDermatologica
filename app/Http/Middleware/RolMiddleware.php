<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next, ...$roles)
{
    $user = Auth::user();

    if (!$user || !in_array($user->rol, $roles)) {
        abort(403, 'No tienes permiso para acceder a esta ruta.');
    }

    return $next($request);
}
}

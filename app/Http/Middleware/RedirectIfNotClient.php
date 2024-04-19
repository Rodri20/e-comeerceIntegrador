<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario tiene el rol de cliente
        if ($request->user() && $request->user()->rol !== 'cliente') {
            return redirect('/'); // Puedes cambiar la ruta de redirección si lo necesitas
        }

        return $next($request);
    }
}

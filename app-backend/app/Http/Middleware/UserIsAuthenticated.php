<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        if($request->input('role') !== 'AUTENTICATO') {

            if($request->input('role') === 'CLIENTE') {
                return redirect('/dashboardcliente');
            }
            elseif($request->input('role') === 'RISTORATORE') {
                return redirect('/dashboardristoratore');
            }

            return redirect('/login');
        }

        return $next($request);
    }
}

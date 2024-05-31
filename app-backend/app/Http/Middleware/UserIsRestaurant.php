<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsRestaurant
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
        if($request->input('role') !== 'RISTORATORE') {

            if($request->input('role') === 'AUTENTICATO') {
                return redirect('/selezionaprofilo');
            }
            elseif($request->input('role') === 'CLIENTE') {
                return redirect('/dashboardcliente');
            }

            return redirect('/login');
        }

        return $next($request);
    }
}

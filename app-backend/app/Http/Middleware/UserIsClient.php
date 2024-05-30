<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsClient
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
        if($request->input('role') !== 'CLIENTE') {

            if($request->input('role') === 'AUTENTICATO') {
                return redirect('/selezionaprofilo');
            }
            elseif($request->input('role') === 'RISTORATORE') {
                return redirect('/dashboardristoratore');
            }

            return redirect('/login');
        }

        return $next($request);
    }
}

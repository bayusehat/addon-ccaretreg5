<?php

namespace App\Http\Middleware;

use Closure;

class IfLogged
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
        if(session('token')){
            if(session('profil') == 1){
                return redirect('obc');
            }else{
                return redirect('oplang');
            }
            
        }

        return $next($request);
    }
}

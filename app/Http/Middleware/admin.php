<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class admin
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
        if (Auth::user() != null) {
            if (Auth::user()->roles_id == 0) {
                return $next($request);
            }else{
                abort(403);
            }
        }else{
            return redirect(route('login'));
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Client
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
        if(! $request->user()->hasRole('client')){
            return redirect('home')->with('error', 'Sorry you do not have permission to Client Dashboard.');
        }

        return $next($request);
    }
}

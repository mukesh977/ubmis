<?php

namespace App\Http\Middleware;

use Closure;

class Accountant
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
        if(! $request->user()->hasRole('accountant')){
            return redirect('home')->with('error', 'Sorry you do not have permission to Accountant Dashboard.');
        }

        return $next($request);
    }
}

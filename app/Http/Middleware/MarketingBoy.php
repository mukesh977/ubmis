<?php

namespace App\Http\Middleware;

use Closure;

class MarketingBoy
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
        if(! $request->user()->hasRole('marketingBoy')){
            return redirect('home')->with('error', 'Sorry you do not have permission to Marketing Boy Dashboard.');
        }

        return $next($request);
    }
}

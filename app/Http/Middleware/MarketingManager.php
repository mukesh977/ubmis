<?php

namespace App\Http\Middleware;

use Closure;

class MarketingManager
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
        if(! $request->user()->hasRole('marketingManager')){
            return redirect('home')->with('error', 'Sorry you do not have permission to Marketing Manager Dashboard.');
        }

        return $next($request);
    }
}

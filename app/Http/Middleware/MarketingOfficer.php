<?php

namespace App\Http\Middleware;

use Closure;

class MarketingOfficer
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
        if(! $request->user()->hasRole('marketingOfficer')){
            return redirect('home')->with('error', 'Sorry you do not have permission to MarketingOfficer Dashboard.');
        }

        return $next($request);
    }
}

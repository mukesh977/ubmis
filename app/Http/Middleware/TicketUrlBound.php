<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TicketUrlBound
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
        if( !empty($request->id) )
        {
            $authenticated_user = Auth::user();

            foreach( $authenticated_user->roles as $role )
              $roles[] = $role->name;

            $ticketAvailabilty = \App\Models\Ticket\Ticket::where('id', '=', $request->id)
                                    ->where( function($q) use ($roles, $authenticated_user){
                                  if( in_array('agent', $roles) )
                                      $q->where('agent_id', '=', $authenticated_user->id);
                                  else if( in_array('admin', $roles) )
                                      $q;
                                  else if( in_array('client', $roles) )
                                      $q->where('user_id', '=', $authenticated_user->id);
                              })
                            ->first();

            if( !empty($ticketAvailabilty) )
                return $next($request);
            else
                return redirect('/tickets');
        }
        return $next($request);
    }
}

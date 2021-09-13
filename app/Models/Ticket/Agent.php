<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\User\User;

class Agent extends User
{
   protected $table = 'users';

  public function agentOpenTickets()
  {
    return $this->hasMany('App\Models\Ticket\Ticket', 'agent_id')->whereNull('completed_at');
  }

  public function name()
  {
    return $this->first_name.' '.$this->last_name;
  }

  public function scopeAgents()
  {
  	$agents = User::join('role_user', 'users.id', 'role_user.user_id')
  								->join('roles', 'role_user.role_id', 'roles.id')
  								->where('roles.name', '=', 'agent')
                  ->orWhere('roles.name', '=', 'admin')
                  ->select('users.*')
  								->get();

  	return $agents;
  }

  public function scopeAgentsWithoutAdmin()
  {
    $agents = User::join('role_user', 'users.id', 'role_user.user_id')
                  ->join('roles', 'role_user.role_id', 'roles.id')
                  ->where('roles.name', '=', 'agent')
                  ->select('users.*')
                  ->get();

    return $agents;
  }

  public function tickets()
  {
    return $this->hasMany('App\Models\Ticket\Ticket', 'agent_id');
  }

  public function agentTickets($complete = false)
  {
    if($complete)
    {
      return $this->hasMany('App\Models\Ticket\Ticket', 'agent_id')->whereNotNull('completed_at');
    }
    else
    {
      return $this->hasMany('App\Models\Ticket\Ticket', 'agent_id')->whereNull('completed_at');
    }
  }

}

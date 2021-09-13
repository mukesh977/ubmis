<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\User\User;

class Client extends User
{
  protected $table = 'users';

  public function name()
  {
    return $this->first_name.' '.$this->last_name;
  }

  public function scopeClients()
  {
    $clients = User::join('role_user', 'users.id', 'role_user.user_id')
                  ->join('roles', 'role_user.role_id', 'roles.id')
                  ->where('roles.name', '=', 'client')
                  ->select('users.*')
                  ->get();

    return $clients;
  }

  public function clientTickets($client = '', $complete = false)
  {
  	if($complete)
  	{
	  	return $this->hasMany('App\Models\Ticket\Ticket', 'user_id')->where('user_id', '=', $client)->whereNotNull('completed_at');
  	}
  	else
  	{
	  	return $this->hasMany('App\Models\Ticket\Ticket', 'user_id')->where('user_id', '=', $client)->whereNull('completed_at');
  	}
  }
  
	public function tickets()
  {
    return $this->hasMany('App\Models\Ticket\Ticket', 'user_id');
  }
  
}

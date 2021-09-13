<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Agent;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
  protected $fillable = ['subject', 'description', 'status_id', 'priority_id', 'user_id', 'agent_id', 'category_id', 'completed_at'];

  public function autoSelectAgent()
  {
    $agents = Agent::join('role_user', 'users.id', 'role_user.user_id')
    ->join('roles', 'roles.id', 'role_user.role_id')
    ->where('name', '=', 'agent')
    ->select('users.*')
    ->get();

    $count = 0;
    $lowestTickets = 1;
    $admin = Agent::join('role_user', 'users.id', 'role_user.user_id')
    ->join('roles', 'roles.id', 'role_user.role_id')
    ->where('name', '=', 'admin')
    ->select('users.*')
    ->first();
    $selectedAgentId = $admin->id;

    foreach( $agents as $agent )
    {
      if( $count == 0 )
      {
        $lowestTickets = $agent->agentOpenTickets->count();
        $selectedAgentId = $agent->id;
      }
      else
      {
        $ticketsCount = $agent->agentOpenTickets->count();
        if( $ticketsCount < $lowestTickets )
        {
          $lowestTickets = $ticketsCount;
          $selectedAgentId = $agent->id;
        }
      }

      $count++;
    }

    $this->agent_id = $selectedAgentId; 

    return $this;
  }

  public function status()
  {
    return $this->belongsTo('\App\Models\Ticket\Status', 'status_id');
  }

  public function agent()
  {
    return $this->belongsTo('\App\Models\Ticket\Agent', 'agent_id');
  }

  public function priority()
  {
    return $this->belongsTo('\App\Models\Ticket\Priorities', 'priority_id');
  }

  public function owner()
  {
    return $this->belongsTo('\App\Models\Ticket\Agent', 'user_id');
  }

  public function category()
  {
    return $this->belongsTo('\App\Models\Ticket\Categories', 'category_id');
  }

  public function comment()
  {
    return $this->hasMany('\App\Models\Ticket\TicketComment', 'ticket_id');
  }
}

<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
 	protected $fillable = ['content', 'user_id', 'ticket_id'];

  public function user()
  {
  	return $this->belongsTo('\App\Models\Ticket\Agent', 'user_id');
  } 
}

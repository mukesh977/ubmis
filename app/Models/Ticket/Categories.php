<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
  protected $table = 'ticket_categories' ;

  public function tickets()
  {
  	return $this->hasMany('App\Models\Ticket\Ticket', 'category_id');
  }
}

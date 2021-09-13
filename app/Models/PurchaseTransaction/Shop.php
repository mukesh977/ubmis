<?php

namespace App\Models\PurchaseTransaction;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function contactNumbers()
    {
    	return $this->morphMany('App\Models\ContactNumber\ContactNumber', 'contact_number');
    }
}

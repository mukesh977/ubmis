<?php

namespace App\Models\ContactNumber;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'company' => 'App\Models\Company\Company',
    'shop' => 'App\Models\PurchaseTransaction\Shop',
]);

class ContactNumber extends Model
{
	protected $fillable = ['name', 'address'];
	
    public function contact_number()
    {
    	return $this->morphTo();
    }
}

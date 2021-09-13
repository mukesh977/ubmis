<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
    	'user_id',
	    'company_id',
	    'target_id',
	    'sales_category_id',
	    'date',
	    'office_name',
	    'received_amount'
    ];

    public function users(){
    	return $this->belongsTo(\App\Models\Access\User\User::class, 'user_id');
    }

    public function companies(){
    	return $this->belongsTo(\App\Models\Company\Company::class, 'company_id');
    }

    public function targets(){
    	return $this->belongsTo(\App\Models\Targets\Target::class, 'target_id');
    }

    public function salesCategories(){
    	return $this->belongsTo(SalesCategory::class, 'sales_category_id');
    }
}

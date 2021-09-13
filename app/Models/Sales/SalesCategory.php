<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesCategory extends Model
{
	protected $table = 'sales_categories';

	protected $fillable = [
		'name',
		'description'
	];

	public function sales(){
		return $this->hasMany(Sales::class, 'sales_category_id');
	}
}

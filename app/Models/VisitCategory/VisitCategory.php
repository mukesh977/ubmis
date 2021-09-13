<?php

namespace App\Models\VisitCategory;

use Illuminate\Database\Eloquent\Model;

class VisitCategory extends Model
{
    protected $table = 'visit_categories';

    protected $fillable = [
    	'name', 'description', 'created_by'
    ];

    public function fieldVisits(){
    	return $this->hasMany(\App\Models\FieldVisit\FieldVisit::class, 'visit_category_id');
    }
}

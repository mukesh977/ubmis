<?php

namespace App\Models\FieldVisit;

use Illuminate\Database\Eloquent\Model;

class VisitorDetail extends Model
{
    protected $table = 'field_visitors';

    protected $fillable = [
    	'field_visit_id',
	    'visitors_contact',
	    'visitors_email'
    ];

    public function fieldVisits(){
    	return $this->belongsTo(FieldVisit::class, 'field_visit_id');
    }
}

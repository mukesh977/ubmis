<?php

namespace App\Models\FieldVisit;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
	protected $table = 'field_visit_contacts';

	protected $fillable = [
		'field_visit_id',
		'contact_number',
		'contact_email'
	];

	public function fieldVisits(){
		return $this->belongsTo(FieldVisit::class, 'field_visit_id');
	}
}

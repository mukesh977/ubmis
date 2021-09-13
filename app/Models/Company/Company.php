<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name'];

    public function fieldVisits(){
    	return $this->hasMany(\App\Models\FieldVisit\FieldVisit::class, 'company_id');
    }

    public function sales(){
    	return $this->hasMany(\App\Models\Sales\Sales::class, 'company_id');
    }

    public function contactNumbers()
    {
    	return $this->morphMany('App\Models\ContactNumber\ContactNumber', 'contact_number');
    }

    public function emails()
    {
        return $this->hasMany('\App\Models\Email\Email', 'company_id');
    }
}

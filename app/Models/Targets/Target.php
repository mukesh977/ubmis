<?php

namespace App\Models\Targets;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';

    protected $fillable = [
    	'name', 
    	'description'
    ];

    public function fieldVisits(){
    	return $this->hasMany(\App\Models\FieldVisit\FieldVisit::class, 'targets_id');
    }

    public function userSales(){
    	return $this->hasMany(\App\Models\Sales\UserSales::class, 'target_id');
    }

    public function userTargets(){
    	return $this->hasMany(UserTarget::class, 'target_id');
    }

    public function sales(){
    	return $this->hasMany(\App\Models\Sales\Sales::class, 'target_id');
    }
}

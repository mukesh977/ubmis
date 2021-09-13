<?php

namespace App\Models\ProjectReferred;

use Illuminate\Database\Eloquent\Model;

class ProjectReferredRelationship extends Model
{
    protected $fillable = ['sales_transaction_id', 'parent_name_id', 'child_name_id'];

    public function parent()
    {
    	return $this->belongsTo('\App\Models\Access\User\User', 'parent_name_id', 'id');
    }

    public function child()
    {
    	return $this->belongsTo('\App\Models\Access\User\User', 'child_name_id', 'id');
    }

    public function salesTransaction()
    {
    	return $this->belongsTo('\App\Models\SalesTransaction\SalesTransaction', 'sales_transaction_id','id');
    }
}

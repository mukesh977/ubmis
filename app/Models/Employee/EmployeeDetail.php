<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    public function role()
    {
    	return $this->belongsTo('\App\Models\Access\Role\Role', 'role_id');
    }
}

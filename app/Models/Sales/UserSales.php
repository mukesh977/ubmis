<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Auth;

class UserSales extends Model
{
    protected $table = 'user_sales';

    protected $fillable = [
    	'user_id',
	    'target_id',
	    'total_sales',
	    'created_by'
    ];

	public function users(){
		return $this->belongsTo(User::class, 'user_id');
	}

	public function targets(){
		return $this->belongsTo(\App\Models\Targets\Target::class, 'target_id');
	}

	public function getTargetedSaleUsers()
	{
		if(Auth::user()->hasRole('admin')){
			$users = User::with('roles', 'roles.permissions')->get();
		}elseif(Auth::user()->hasRole('marketingManager')){
			$roleId = Role::where('name', '=', 'marketingOfficer')->pluck('id');
			$users = User::with('roles', 'roles.permissions')
			             ->whereHas('roles', function($query) use($roleId){
				             $query->whereIn('role_id', $roleId);
			             })->get();
		}

		return $users;
	}
}

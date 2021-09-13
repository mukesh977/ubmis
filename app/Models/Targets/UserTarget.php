<?php

namespace App\Models\Targets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;

class UserTarget extends Model
{
    protected $table = 'user_targets';

    protected $fillable = [
    	'user_id',
	    'target_id',
	    'total_target',
	    'created_by'
    ];

    public function users(){
    	return $this->belongsTo(\App\Models\Access\User\User::class, 'user_id');
    }

    public function targets(){
    	return $this->belongsTo(\App\Models\Targets\Target::class, 'target_id');
    }

    public function getTargetedUsers()
    {
	    if(Auth::user()->hasRole('admin')){
		    $users = User::with('roles', 'roles.permissions')->get();
	    }elseif(Auth::user()->hasRole('marketingManager')){
		    $roleId = Role::where('name', '=', 'marketingOfficer')
		                  ->orWhere('name', '=', 'marketingBoy')->pluck('id');
		    $users = User::with('roles', 'roles.permissions')
		                 ->whereHas('roles', function($query) use($roleId){
			                 $query->whereIn('role_id', $roleId);
		                 })->get();
	    }

	    return $users;
    }
}

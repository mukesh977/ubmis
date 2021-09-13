<?php

namespace App\Models\Access\Role;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\Auth;

class Role extends EntrustRole
{
	protected $table = 'roles';

	protected $fillable = [
		'name',
		'display_name',
		'description'
	];

	public function users(){
		return $this->belongsToMany(\App\Models\Access\User\User::class, 'role_user');
	}

	public function permissions(){
		return $this->belongsToMany(\App\Models\Access\Permission\Permission::class, 'permission_role', 'role_id', 'permission_id');
	}

	public function getRoles()
	{
		if(Auth::user()->hasRole('admin')){
			$roles = Role::with('permissions')->whereNotIn('name', ['admin', 'client'])->get();
		}elseif(Auth::user()->hasRole('marketingManager')){
			$roles = Role::with('permissions')->whereIn('name', ['marketingBoy', 'marketingOfficer'])->get();
		}elseif(Auth::user()->hasRole('marketingOfficer')){
			$roles = Role::with('permissions')->where('name', 'marketingBoy')->get();
		}

		return $roles;
	}

}

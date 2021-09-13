<?php

namespace App\Models\Access\Permission;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	protected $table = 'permissions';

	protected $fillable = [
		'name',
		'display_name',
		'description'
	];

	public function roles(){
		return $this->belongsToMany(\App\Models\Access\Role\Role::class, 'permission_role', 'role_id', 'permission_id');
	}

}

<?php

namespace App\Models\Access\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Access\Role\Role;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
	use Notifiable;
	use EntrustUserTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = 'users';
	protected $fillable = [
		'first_name', 'last_name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function roles(){
		return $this->belongsToMany(\App\Models\Access\Role\Role::class, 'role_user');
	}

	public function name()
	{
		return $this->first_name.' '.$this->last_name;
	}

	public function fieldVisits(){
		return $this->hasMany(\App\Models\FieldVisit\FieldVisit::class, 'user_id');
	}

	public function userTargets(){
		return $this->hasMany(\App\Models\Targets\UserTarget::class, 'user_id');
	}

	public function userSales(){
		return $this->hasMany(\App\Models\Sales\UserSales::class, 'user_id');
	}

	public function sales(){
		return $this->hasMany(\App\Models\Sales\Sales::class, 'user_id');
	}

	public function getUsersAccToRole()
	{
		if(Auth::user()->hasRole('admin')){
			$roleId = Role::whereNotIn('name', ['admin'])->pluck('id');
			$users = User::with('roles', 'roles.permissions')
			             ->whereHas('roles', function($query) use($roleId){
				             $query->whereIn('role_id', $roleId);
			             })->get();
		}else if(Auth::user()->hasRole('marketingManager')){
			$roleId = Role::where('name', '=', 'marketingOfficer')
			              ->orWhere('name', '=', 'marketingBoy')->pluck('id');
			$users = User::with('roles', 'roles.permissions')
			             ->whereHas('roles', function($query) use($roleId){
				             $query->whereIn('role_id', $roleId);
			             })->get();
		}else if(Auth::user()->hasRole('marketingOfficer')){
			$roleId = Role::where('name', '=', 'marketingBoy')->pluck('id');
			$users = User::with('roles', 'roles.permissions')
			             ->whereHas('roles', function($query) use($roleId){
				             $query->whereIn('role_id', $roleId);
			             })->get();
		}

		return $users;
	}

}

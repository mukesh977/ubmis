<?php

namespace App\Models\FieldVisit;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Auth;

class FieldVisit extends Model
{
   	protected $table = 'field_visits';

   	protected $fillable = [
   		'user_id',
   		'targets_id',
   		'visit_category_id',
   		'company_id',
   		'date',
   		'email_address',
   		'address',
   		'visited_to',
   		'visitors_contact',
   		'visitors_email',
   		'contact_person',
   		'contact_number',
   		'contact_email',
   		'requirements',
   		'next_visit_date',
   		'project_status',
	    'project_scope',
   		'reasons',
   		'weakness',
   		'comments',
   		'next_visit_comments',
	    'status',
	    'assigned_by',
	    'assigned_to',
	    'assigned_date'
   	];

   	public function users()
   	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function companies(){
   		return $this->belongsTo(\App\Models\Company\Company::class, 'company_id');
	}

	public function fieldVisitAssignedBy()
	{
		return $this->belongsTo(User::class, 'assigned_by');
	}

	public function fieldVisitAssignedTo()
	{
		return $this->belongsTo(User::class, 'assigned_to');
	}

	public function targets(){
		return $this->belongsTo(\App\Models\Targets\Target::class,'targets_id');
	}

	public function visitCategories(){
		return $this->belongsTo(\App\Models\VisitCategory\VisitCategory::class, 'visit_category_id');
	}

	public function contactDetails(){
   		return $this->hasMany(ContactDetail::class, 'field_visit_id');
	}

	public function visitorDetails(){
		return $this->hasMany(VisitorDetail::class, 'field_visit_id');
	}

	public function sales(){
   		return $this->hasMany(\App\Models\Sales\Sales::class, 'field_visit_id');
	}

	public function getUserForVisitAssign()
	{
		if(Auth::user()->hasRole('admin')){
			$roleId = Role::whereNotIn('name', ['admin'])->pluck('id');
			$users = User::whereHas('roles', function($query) use($roleId){
				$query->whereIn('role_id', $roleId);
			})->get();
		}else if(Auth::user()->hasRole('marketingManager')){
			$roleId = Role::where('name', '=', 'marketingOfficer')
			              ->orWhere('name', '=', 'marketingBoy')->pluck('id');
			$users = User::whereHas('roles', function($query) use($roleId){
				$query->whereIn('role_id', $roleId);
			})->get();
		}else if(Auth::user()->hasRole('marketingOfficer')){
			$roleId = Role::where('name', '=', 'marketingBoy')->pluck('id');
			$users = User::whereHas('roles', function($query) use($roleId){
				$query->whereIn('role_id', $roleId);
			})->get();
		}else{
			$users = '';
		}

		return $users;
	}
}

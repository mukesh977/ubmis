<?php

use Illuminate\Database\Seeder;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    foreach(config('permissions') as $permissions){
		    foreach($permissions as $permission){
			    Permission::firstOrCreate($permission);
		    }
	    }

	    $this->attachPermissionsToRole();
    }

	private function attachPermissionsToRole() {
		\DB::table( config( 'entrust.permission_role_table' ) )->truncate();
		$roles = Role::whereIn( 'name', [
			'admin',
			'marketingManager',
			'marketingOfficer',
			'marketingBoy',
		] )->get();
		foreach ( $roles as $role ) {
			$method = 'get' . ucwords( $role->name ) . 'Permissions';
			$role->perms()->sync( $this->{$method}() );
		}
	}

	protected function getAdminPermissions(){
    	return Permission::whereIn('name', [
    		'manage.dashboard',
    		'only.view.dashboard',
		    'manage.marketing.manager',
		    'only.view.marketing.manager',
		    'manage.marketing.officer',
		    'only.view.marketing.officer',
		    'manage.marketing.boy',
		    'only.view.marketing.boy',
	    ])->pluck('id', 'id')->toArray();
	}

	protected function getMarketingManagerPermissions(){
		return Permission::whereIn('name', [
			'only.view.dashboard',
			'manage.marketing.officer',
			'only.view.marketing.officer',
			'manage.marketing.boy',
			'only.view.marketing.boy',
		])->pluck('id', 'id')->toArray();
	}

	protected function getMarketingOfficerPermissions(){
		return Permission::whereIn('name', [
			'only.view.dashboard',
			'manage.marketing.boy',
			'only.view.marketing.boy',
		])->pluck('id', 'id')->toArray();
	}

	protected function getMarketingBoyPermissions(){
		return Permission::whereIn('name', [
			'only.view.dashboard',
			'only.view.marketing.boy',
		])->pluck('id', 'id')->toArray();
	}
}

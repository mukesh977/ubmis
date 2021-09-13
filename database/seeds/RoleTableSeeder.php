<?php

use Illuminate\Database\Seeder;
use App\Models\Access\Role\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    foreach(config('roles') as $roles){
		    foreach($roles as $role){
			    Role::firstOrCreate($role);
		    }
	    }
    }
}

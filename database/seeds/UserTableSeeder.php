<?php

use Illuminate\Database\Seeder;
use App\Models\Access\User\User;
use App\Models\Access\Role\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = "Ultrabyte";
        $user->last_name = "Admin";
        $user->email = "info@ultrabyte.com";
        $user->password = bcrypt('Ultrabyte@1234%');
        $user->save();

        $role = Role::find(1);
        $user->roles()->attach($role->id);

	    $user = new User();
	    $user->first_name = "Marketing";
	    $user->last_name = "Manager";
	    $user->email = "marketing.manager@ultrabyte.com";
	    $user->password = bcrypt('Manager@123');
	    $user->save();

	    $role = Role::find(2);
	    $user->roles()->attach($role->id);

	    $user = new User();
	    $user->first_name = "Marketing";
	    $user->last_name = "Officer";
	    $user->email = "marketing.officer@ultrabyte.com";
	    $user->password = bcrypt('Officer@123');
	    $user->save();

	    $role = Role::find(3);
	    $user->roles()->attach($role->id);

	    $user = new User();
	    $user->first_name = "Marketing";
	    $user->last_name = "Boy";
	    $user->email = "marketing.boy@ultrabyte.com";
	    $user->password = bcrypt('Boy@123');
	    $user->save();

	    $role = Role::find(4);
	    $user->roles()->attach($role->id);
    }
}

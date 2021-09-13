<?php

use Illuminate\Database\Seeder;

class TargetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $targets = [
	        ['name' => 'Daily', 'description' => 'Daily visits by Marketing manager, boy, or officers.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Weekly', 'description' => 'Weekly visits by Marketing manager, boy, or officers.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Quarterly', 'description' => 'Quarterly visits by Marketing manager, boy, or officers.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Monthly', 'description' => 'Monthly visits by Marketing manager, boy, or officers.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
        ];

	    \Illuminate\Support\Facades\DB::table('targets')->insert($targets);
    }
}

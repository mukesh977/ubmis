<?php

use Illuminate\Database\Seeder;

class VisitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
	        ['name' => 'School/Colleges', 'description' => 'visits by Marketing manager, boy, or officers to school/Colleges', 'created_by' => 1, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'NGOs/INGOs', 'description' => 'visits by Marketing manager, boy, or officers to NGOs/INGOs', 'created_by' => 1, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Manpower', 'description' => 'visits by Marketing manager, boy, or officers to Manpower', 'created_by' => 1, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Hospital', 'description' => 'visits by Marketing manager, boy, or officers to Hospital', 'created_by' => 2, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Spa', 'description' => 'visits by Marketing manager, boy, or officers to Spa', 'created_by' => 2, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'E-commerce', 'description' => 'visits by Marketing manager, boy, or officers to E-commerce', 'created_by' => 2, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Travels & Tours', 'description' => 'visits by Marketing manager, boy, or officers to Travels & Tours', 'created_by' => 2, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
	        ['name' => 'Others', 'description' => 'visits by Marketing manager, boy, or officers to Others', 'created_by' => 2, 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
        ];

        \Illuminate\Support\Facades\DB::table('visit_categories')->insert($categories);
    }
}

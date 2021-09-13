<?php

use Illuminate\Database\Seeder;

class FieldVisitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $field_visits  = [
        	['user_id' => 3, 'targets_id' => 1, 'visit_category_id' => 1, 'company_id' => 1, 'date' => '2018-09-10', 'email_address' => 'info@basantapur.com', 'visited_to' => 'Principal', 'contact_person' => 'UltraByte CEO', 'requirements' => 'Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,  At vero eos et accusam et justo duo dolores et ea rebum. ', 'next_visit_date' => '2018-10-10', 'project_status' => '1','reasons' => 'Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat. ', 'project_scope'=> 'High', 'weakness' => 'Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat', 'comments' => 'Lorem ipsum dolor sit amet,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]
        ];

        \Illuminate\Support\Facades\DB::table('field_visits')->insert($field_visits);
    }
}

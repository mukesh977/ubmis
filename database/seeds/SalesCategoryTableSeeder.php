<?php

use Illuminate\Database\Seeder;

class SalesCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salesCategories = [
        	['name' => 'Website', 'description' => 'Sales for website category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'SEO', 'description' => 'Sales for SEO category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'Facebook', 'description' => 'Sales for Facebook category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'Graphics', 'description' => 'Sales for Graphics category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'System', 'description' => 'Sales for System category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'Animation', 'description' => 'Sales for Animation category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        	['name' => 'Apps', 'description' => 'Sales for Apps category.', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        ];

        \Illuminate\Support\Facades\DB::table('sales_categories')->insert($salesCategories);
    }
}

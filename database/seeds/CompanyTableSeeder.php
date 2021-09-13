<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
        	['name' => 'Ultrabyte Pvt. Ltd.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
        	['name' => 'Vurung Pvt. Ltd.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
        	['name' => 'Nepal NGOs Pvt. Ltd.', 'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()],
        ];

        \Illuminate\Support\Facades\DB::table('companies')->insert($datas);
    }
}

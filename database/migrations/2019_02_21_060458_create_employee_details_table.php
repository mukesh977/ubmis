<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('role_id');
            $table->string('name');
            $table->string('date_of_birth');
            $table->string('email');
            $table->string('mobile_number');
            $table->string('phone_number');
            $table->string('temporary_address');
            $table->string('temporary_tole');
            $table->string('temporary_ward');
            $table->string('permanent_address');
            $table->string('permanent_tole');
            $table->string('permanent_ward');
            $table->string('fb_link');
            $table->string('twitter_link');
            $table->string('personal_website_link');
            $table->string('bank_name_1');
            $table->string('swift_code_1');
            $table->string('bank_number_1');
            $table->string('branch_1');
            $table->string('bank_name_2')->nullable();
            $table->string('swift_code_2')->nullable();
            $table->string('bank_number_2')->nullable();
            $table->string('branch_2')->nullable();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('grandfather_name');
            $table->string('grandmother_name');
            $table->string('brother_name');
            $table->string('blood_group');
            $table->string('esewa_id');
            $table->string('education');
            $table->string('college_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_details');
    }
}

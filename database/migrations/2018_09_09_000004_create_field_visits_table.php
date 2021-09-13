<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldVisitsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'field_visits';

    /**
     * Run the migrations.
     * @table field_visits
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('targets_id');
            $table->unsignedInteger('visit_category_id');
	        $table->unsignedInteger('company_id');
            $table->date('date')->nullable();
            $table->string('office_name', 100)->nullable();
            $table->string('email_address', 100)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('visited_to')->nullable();
            $table->string('contact_person')->nullable();
            $table->longText('requirements')->nullable();
            $table->date('next_visit_date')->nullable();
            $table->tinyInteger('project_status')->nullable();
            $table->longText('reasons')->nullable();
            $table->string('project_scope')->nullable();
            $table->longText('weakness')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('next_visit_comments')->nullable();
	        $table->unsignedInteger('assigned_by')->nullable();
	        $table->unsignedInteger('assigned_to')->nullable();
	        $table->date('assigned_date')->nullable();
            $table->nullableTimestamps();


            $table->foreign('assigned_by')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

	        $table->foreign('assigned_to')
	              ->references('id')->on('users')
	              ->onDelete('cascade')
	              ->onUpdate('cascade');

	        $table->foreign('user_id')
	              ->references('id')->on('users')
	              ->onDelete('cascade')
	              ->onUpdate('cascade');

            $table->foreign('targets_id')
                ->references('id')->on('targets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

	        $table->foreign('visit_category_id')
	              ->references('id')->on('visit_categories')
	              ->onDelete('cascade')
	              ->onUpdate('cascade');

	        $table->foreign('company_id')
	              ->references('id')->on('companies')
	              ->onDelete('cascade')
	              ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}

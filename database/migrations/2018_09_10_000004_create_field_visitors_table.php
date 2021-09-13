<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldVisitorsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'field_visitors';

    /**
     * Run the migrations.
     * @table field_visitors
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('field_visit_id');
            $table->string('visitors_contact')->nullable();
            $table->string('visitors_email')->nullable();

            $table->index(["field_visit_id"], 'fk_field_visitors_field_visits1_idx');
            $table->nullableTimestamps();


            $table->foreign('field_visit_id', 'fk_field_visitors_field_visits1_idx')
                ->references('id')->on('field_visits')
                ->onDelete('no action')
                ->onUpdate('no action');
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

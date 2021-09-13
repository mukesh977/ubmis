<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectReferredRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_referred_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sales_transaction_id');
            $table->bigInteger('parent_name_id')->nullable();
            $table->bigInteger('child_name_id')->nullable();
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
        Schema::dropIfExists('project_referred_relationships');
    }
}

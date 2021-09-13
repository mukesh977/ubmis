<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelyNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timely_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id');
            $table->bigInteger('sales_transaction_id');
            $table->bigInteger('sales_transaction_item_id');
            $table->integer('service_id');
            $table->string('information');
            $table->integer('remaining_days');
            $table->date('expiration_date');
            $table->date('updated_expiration_date')->nullable();
            $table->boolean('successfully_sent');
            $table->boolean('seen');
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
        Schema::dropIfExists('timely_notifications');
    }
}

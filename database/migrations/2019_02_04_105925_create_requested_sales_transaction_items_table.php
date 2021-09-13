<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestedSalesTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_sales_transaction_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('r_transaction_id')->unsigned();
            $table->foreign('r_transaction_id')->references('id')
                                            ->on('requested_sales_transactions')
                                            ->onDelete('cascade');
            $table->string('r_items')->nullable();
            $table->integer('r_quantity')->nullable();
            $table->string('r_unit')->nullable();
            $table->double('r_rate', 15, 2)->nullable();
            $table->integer('r_service_id')->nullable();
            $table->double('r_total_price', 15, 2);
            $table->date('r_disk_space')->nullable();
            $table->date('r_start_date')->nullable();
            $table->date('r_end_date')->nullable();
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
        Schema::dropIfExists('requested_sales_transaction_items');
    }
}

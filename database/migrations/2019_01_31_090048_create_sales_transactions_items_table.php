<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transactions_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_transaction_id')->unsigned();
            $table->foreign('sales_transaction_id')->references('id')
                                            ->on('sales_transactions')
                                            ->onDelete('cascade');
            $table->integer('service_id');
            $table->double('total_price', 15, 2);
            $table->string('disk_space')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

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
        Schema::dropIfExists('sales_transactions_items');
    }
}

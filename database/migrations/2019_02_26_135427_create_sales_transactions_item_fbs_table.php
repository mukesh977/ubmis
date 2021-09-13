<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTransactionsItemFbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transactions_item_fbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_transactions_item_id')->unsigned();
            $table->foreign('sales_transactions_item_id')->references('id')
                                            ->on('sales_transactions_items')
                                            ->onDelete('cascade');
            $table->string('particulars');
            $table->double('dollar', 15, 2);
            $table->double('graphics', 15, 2);
            $table->double('total', 15, 2);
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
        Schema::dropIfExists('sales_transactions_item_fbs');
    }
}

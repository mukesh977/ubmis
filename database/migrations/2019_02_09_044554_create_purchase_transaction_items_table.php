<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_transaction_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_transaction_id')->unsigned();
            $table->foreign('purchase_transaction_id')->references('id')
                                            ->on('purchase_transactions')
                                            ->onDelete('cascade');
            $table->string('items');
            $table->double('rate', 15, 2);
            $table->integer('quantity');
            $table->string('unit');
            $table->double('total_price', 15, 2);
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
        Schema::dropIfExists('purchase_transaction_items');
    }
}

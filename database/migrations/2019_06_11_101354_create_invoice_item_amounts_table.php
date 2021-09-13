<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_item_id')->unsigned();
            $table->foreign('invoice_item_id')->references('id')
                                            ->on('invoice_items')
                                            ->onDelete('cascade')
                                            ->onUpdate('cascade');
                                            
            $table->bigInteger('invoice_item_group_id')->unsigned();

            $table->double('total_paid_amount', 15, 2);
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
        Schema::dropIfExists('invoice_item_amounts');
    }
}

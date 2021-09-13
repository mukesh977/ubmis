<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestedSTItemFbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_s_t_item_fbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('r_s_t_item_id')->unsigned();
            $table->foreign('r_s_t_item_id')->references('id')
                                            ->on('requested_sales_transaction_items')
                                            ->onDelete('cascade');
            $table->string('r_particulars');
            $table->double('r_dollar', 15, 2);
            $table->double('r_graphics', 15, 2);
            $table->double('r_total', 15, 2);
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
        Schema::dropIfExists('requested_s_t_item_fbs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseInstallmentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_installment_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_transaction_id')->unsigned();
            $table->foreign('purchase_transaction_id')->references('id')
                                            ->on('purchase_transactions')
                                            ->onDelete('cascade');
            $table->integer('user_id');
            $table->double('paid_amount', 15, 2);
            $table->integer('payment_method');
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
        Schema::dropIfExists('purchase_installment_payments');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInstallmentPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_installment_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_transaction_id')->unsigned();
            $table->foreign('sales_transaction_id')->references('id')
                                            ->on('sales_transactions')
                                            ->onDelete('cascade');
            $table->integer('user_id');
            $table->double('paid_amount', 15, 2);
            $table->integer('payment_method');
            $table->string('cheque_number');
            $table->date('date');
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
        Schema::dropIfExists('sales_installment_payments');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestedSalesInstallmentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_sales_installment_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('r_transaction_id')->unsigned();
            $table->foreign('r_transaction_id')->references('id')
                                            ->on('requested_sales_transactions')
                                            ->onDelete('cascade');
            $table->integer('r_user_id');
            $table->double('r_paid_amount', 15, 2);
            $table->integer('r_payment_method');
            $table->string('r_cheque_number')->nullable();
            $table->date('r_date');
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
        Schema::dropIfExists('requested_sales_installment_payments');
    }
}

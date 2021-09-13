<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestedSalesTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_sales_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('r_actual_sale_id')->nullable();
            $table->integer('r_actual_purchase_id')->nullable();
            $table->integer('r_user_id');
            $table->integer('r_company_id')->nullable();
            $table->integer('r_shop_id')->nullable();
            $table->integer('r_referred_by')->nullable();
            $table->string('r_sales_code')->nullable();
            $table->string('r_purchase_code')->nullable();
            $table->date('r_date');
            $table->double('r_total_amount', 15, 2);
            $table->double('r_total_paid_amount', 15, 2);
            $table->double('r_total_unpaid_amount', 15, 2);
            $table->boolean('r_payment_complete_status');
            $table->string('r_operation');
            $table->boolean('completed');
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
        Schema::dropIfExists('requested_sales_transactions');
    }
}

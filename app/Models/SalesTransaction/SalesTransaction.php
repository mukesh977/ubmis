<?php

namespace App\Models\SalesTransaction;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    public function company()
    {
    	return $this->belongsTo('App\Models\Company\Company', 'company_id', 'id');
    }

    public function salesTransactionsItem()
    {
    	return $this->hasMany('\App\Models\SalesTransaction\SalesTransactionsItem', 'sales_transaction_id');
    }

    public function salesInstallmentPayment()
    {
    	return $this->hasMany('\App\Models\SalesTransaction\SalesInstallmentPayment', 'sales_transaction_id');
    }

    public function salesTransactionsItemFb()
    {
        return $this->hasManyThrough('\App\Models\SalesTransaction\SalesTransactionsItemFb', '\App\Models\SalesTransaction\SalesTransactionsItem', 'sales_transaction_id', 'sales_transactions_item_id', 'id');
    }

    public function referredBy()
    {
        return $this->belongsTo('\App\Models\Access\User\User', 'referred_by', 'id');
    }

}

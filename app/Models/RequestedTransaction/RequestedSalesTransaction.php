<?php

namespace App\Models\RequestedTransaction;

use Illuminate\Database\Eloquent\Model;

class RequestedSalesTransaction extends Model
{
    public function requestedSalesTransactionItem()
    {
    	return $this->hasMany('\App\Models\RequestedTransaction\RequestedSalesTransactionItem', 'r_transaction_id');
    }

    public function requestedSalesInstallmentPayment()
    {
    	return $this->hasMany('\App\Models\RequestedTransaction\RequestedSalesInstallmentPayment', 'r_transaction_id');
    }

    public function user()
    {
    	return $this->belongsTo('\App\Models\Access\User\User', 'r_user_id');
    }

    public function requestedSTItemFb()
    {
        return $this->hasManyThrough('\App\Models\RequestedTransaction\RequestedSTItemFb', '\App\Models\RequestedTransaction\RequestedSalesTransactionItem', 'r_transaction_id', 'r_s_t_item_id', 'id');
    }

}

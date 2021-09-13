<?php

namespace App\Models\RequestedTransaction;

use Illuminate\Database\Eloquent\Model;

class RequestedSalesTransactionItem extends Model
{
    public function requestedSTItemFb()
    {
    	$this->hasMany('\App\Models\RequestedTransaction\RequestedSTItemFb', 'sales_transactions_item_id');
    }
}

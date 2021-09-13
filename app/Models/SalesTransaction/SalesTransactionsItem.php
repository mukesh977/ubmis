<?php

namespace App\Models\SalesTransaction;

use Illuminate\Database\Eloquent\Model;

class SalesTransactionsItem extends Model
{
    public function salesCategory()
    {
        return $this->belongsTo('\App\Models\Sales\SalesCategory', 'service_id');
    }

    public function salesTransaction()
    {
    	return $this->belongsTo('\App\Models\SalesTransaction\SalesTransaction', 'sales_transaction_id', 'id');
    }

    public function salesTransactionsItemFb()
    {
    	return $this->hasMany('\App\Models\SalesTransaction\SalesTransactionsItemFb', 'sales_transactions_item_id', 'id');
    }

}

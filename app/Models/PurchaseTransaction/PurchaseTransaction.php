<?php

namespace App\Models\PurchaseTransaction;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    public function purchaseTransactionItem()
    {
    	return $this->hasMany('\App\Models\PurchaseTransaction\PurchaseTransactionItem', 'purchase_transaction_id');
    }

    public function purchaseInstallmentPayment()
    {
    	return $this->hasMany('\App\Models\PurchaseTransaction\PurchaseInstallmentPayment', 'purchase_transaction_id');
    }

    public function shop()
    {
    	return $this->belongsTo('\App\Models\PurchaseTransaction\Shop', 'shop_id');
    }
}

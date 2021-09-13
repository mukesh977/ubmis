<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id', 'group_id', 'service_id', 'information', 'total_price'];

    public function invoiceItemAmounts()
    {
    	return $this->hasOne('\App\Models\Invoice\InvoiceItemAmount', 'invoice_item_group_id', 'group_id');
    }

    public function salesCategory()
    {
    	return $this->belongsTo('\App\Models\Sales\SalesCategory', 'service_id', 'id');
    }
}

<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemAmount extends Model
{
    protected $fillable = ['invoice_item_id', 'invoice_item_group_id', 'total_paid_amount'];
}

<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['company_id', 'bill_no', 'date', 'previous_due_amount', 'total_due_amount'];

    public function company()
    {
    	return $this->belongsTo('\App\Models\Company\Company', 'company_id', 'id');
    }

    public function invoiceItems()
    {
    	return $this->hasMany('\App\Models\Invoice\InvoiceItem', 'invoice_id');
    }
}

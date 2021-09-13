<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class TimelyNotification extends Model
{
    protected $fillable = ['company_id', 'sales_transaction_item_id', 'service_id', 'information', 'remaining_days', 'successfully_sent', 'seen', 'task_done'];


    public function company()
    {
    	return $this->belongsTo('App\Models\Company\Company', 'company_id', 'id');
    }

    public function service()
    {
    	return $this->belongsTo('\App\Models\Sales\SalesCategory', 'service_id', 'id');
    }
}

<?php

namespace App\Models\Calendar;

use Illuminate\Database\Eloquent\Model;

class ClientFollowUpModel extends Model
{
    protected $table = 'client_follow_ups';

    public function company()
    {
    	return $this->belongsTo('\App\Models\Company\Company', 'company_id', 'id');
    }
}

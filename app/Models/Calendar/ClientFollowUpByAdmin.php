<?php

namespace App\Models\Calendar;

use Illuminate\Database\Eloquent\Model;

class ClientFollowUpByAdmin extends Model
{
    protected $table = 'client_follow_up_by_admin';

    public function company()
    {
    	return $this->belongsTo('\App\Models\Company\Company', 'company_id', 'id');
    }
}

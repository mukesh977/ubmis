<?php

namespace App\Http\Controllers\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification\TimelyNotification;
use App\Models\Sales\SalesCategory;
use App\Models\Package\SeoPackage;
use App\Models\Package\AmcPackage;
use App\Models\FieldVisit\FieldVisit;

class AccountantNotification extends Controller
{
    public function getSingleNotication( $id = '' )
    {
    	$services = SalesCategory::all();
    	$seoPackages = SeoPackage::all();
    	$amcPackages = AmcPackage::all();

    	if( TimelyNotification::where('id', '=', $id)->first()->seen == 0 )
	    	TimelyNotification::where('id', '=', $id)->update(['seen' => 1]);

    	$singleNotification = TimelyNotification::with('company.contactNumbers')->with('company.emails')
    							->where('id', '=', $id)
    							->first();

        $fieldVisitContacts = FieldVisit::with('contactDetails')
                                            ->where('company_id', '=', $singleNotification->company_id)
                                            ->orderBy('created_at', 'DESC')
                                            ->get();


    							// dd($singleNotification);
    	return view('notifications.accountant-notification')
    							->with('singleNotification', $singleNotification)
    							->with('seoPackages', $seoPackages)
    							->with('amcPackages', $amcPackages)
                                ->with('fieldVisitContacts', $fieldVisitContacts)
    							->with('services', $services);
    }

    public function notificationCalendar()
    {
      $employees = \App\Models\Employee\EmployeeDetail::all();
      $clientFollowUp = \App\Models\Calendar\ClientFollowUpModel::with('company')->get();

      return view('calendar.calendar')->with('employees', $employees)
                                            ->with('clientFollowUp', $clientFollowUp);
    }
}

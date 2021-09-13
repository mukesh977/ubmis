<?php

namespace App\Http\Controllers\Reports;

use App\Models\FieldVisit\FieldVisit;
use App\Models\Sales\Sales;
use App\Models\Sales\SalesCategory;
use App\Models\VisitCategory\VisitCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class ReportController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function getUserSalesReports()
    {
    	$userId = Auth::user()->id;
    	$salesCategories = SalesCategory::all();
    	$reportsData =  array();
    	foreach($salesCategories as $count => $category){

		    $reportsData[$count]['y'] = Sales::where('user_id', $userId)
                                                  ->where('sales_category_id', $category->id)
			                                        ->sum('received_amount');
		    $reportsData[$count]['legendText'] = ucfirst($category->name);
		    $reportsData[$count]['label'] = ucfirst($category->name);
	    }

	    $user = Auth::user()->first_name.' '.Auth::user()->last_name;

    	return view('reports.sales.sales-reports', compact('reportsData', 'user'));
    }

    public function getUserVisitReports()
    {
    	$user = Auth::user()->first_name.' '.Auth::user()->last_name;
	    $userId = Auth::user()->id;
//    	$fieldVisits = FieldVisit::where('user_id', $userId)->get();
    	$reportsData = array();
    	for($i=0; $i < 2; $i++){
		    $reportsData[$i]['y'] =  FieldVisit::where('user_id', $userId)->where('project_status', $i)->count();
		    if($i == 0){
			    $reportsData[$i]['legendText'] = 'Negative';
			    $reportsData[$i]['label'] = 'Negative';
		    }else{
			    $reportsData[$i]['legendText'] = 'Positive';
			    $reportsData[$i]['label'] = 'Positive';
		    }
	    }

	    $visitReports = array();
    	$visitCategories = VisitCategory::all();
    	foreach($visitCategories as $i => $category){
		    $visitReports[$i]['y'] =  FieldVisit::where('user_id', $userId)->where('visit_category_id', $category->id)->count();
		    $visitReports[$i]['legendText'] = ucfirst($category->name);
		    $visitReports[$i]['label'] = ucfirst($category->name);
	    }

		return view('reports.visits.visit-reports', compact('user', 'reportsData', 'visitReports'));
    }
}

<?php

namespace App\Http\Controllers\FieldVisit;

use App\Models\FieldVisit\FieldVisit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class UserFieldVisitController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function weeklyFieldVisit()
    {
	    $users = ( new FieldVisit())->getUserForVisitAssign();

	    $user_id = Auth::user()->id;
	    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
	                            ->whereHas('targets', function($query){
		                            $query->where('name', '=', 'Weekly');
	                            })
	                            ->where('user_id', $user_id)->get();

	    return view('fieldVisits.index', compact('visitDatas', 'users'));
    }

	public function monthlyFieldVisit()
	{
		$users = ( new FieldVisit())->getUserForVisitAssign();

		$user_id = Auth::user()->id;
		$visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
		                        ->whereHas('targets', function($query){
			                        $query->where('name', '=', 'Monthly');
		                        })
		                        ->where('user_id', $user_id)->get();

		return view('fieldVisits.index', compact('visitDatas', 'users'));
	}

	public function quarterlyFieldVisit()
	{
		$users = ( new FieldVisit())->getUserForVisitAssign();

		$user_id = Auth::user()->id;
		$visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
		                        ->whereHas('targets', function($query){
			                        $query->where('name', '=', 'Quarterly');
		                        })
		                        ->where('user_id', $user_id)->get();

		return view('fieldVisits.index', compact('visitDatas', 'users'));
	}
}

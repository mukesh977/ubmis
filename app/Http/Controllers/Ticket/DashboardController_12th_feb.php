<?php

namespace App\Http\Controllers\Ticket;

use App\Models\FieldVisit\FieldVisit;
use App\Http\Controllers\Controller;
use App\Models\Sales\Sales;
use App\Models\Sales\UserSales;
use App\Models\Targets\Target;
use App\Models\Targets\UserTarget;
use App\Models\VisitCategory\VisitCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:admin|marketingBoy|marketingOfficer|marketingManager|accountant|client|supporter|agent');
	}

	public function index()
	{
		$userId = Auth::user()->id;
		$targets = Target::all();
		$field_visit_start_date = FieldVisit::where('user_id', $userId)->orderBy('id', 'asc')->first();
		$total_weekly_visits = 0;
		$total_monthly_visits = 0;
		$total_quarterly_visits = 0;
		if ($field_visit_start_date){
			$weeklyDate = Carbon::parse($field_visit_start_date->date)->addDays(7)->toDateString();
			$monthlyDate = Carbon::parse($field_visit_start_date->date)->addDays(30)->toDateString();
			$quarterlyDate = Carbon::parse($field_visit_start_date->date)->addDays(90)->toDateString();
		}
		foreach($targets as $target){
			switch ($target->name){
				case 'Daily':
				$dailyFieldVisits = FieldVisit::where('user_id', $userId)
				->where('targets_id', $target->id)->count();

				$total_daily_visits = FieldVisit::where( 'user_id', $userId )
				->where( 'date', Carbon::now()->toDateString() )
				->where( 'targets_id', $target->id )->count();
				case 'Weekly':
				$weeklyFieldVisits = FieldVisit::where('user_id', $userId)
				->where('targets_id', $target->id)->count();
				if ($field_visit_start_date) {
					$total_weekly_visits = FieldVisit::where( 'user_id', $userId )
					->whereBetween( 'date', [
						$field_visit_start_date->date,
						$weeklyDate
					] )->count();
				}
				break;
				case 'Monthly':
				$monthlyFieldVisits = FieldVisit::where('user_id', $userId)
				->where('targets_id', $target->id)->count();
				if ($field_visit_start_date) {
					$total_monthly_visits = FieldVisit::where( 'user_id', $userId )
					->whereBetween( 'date', [
						$field_visit_start_date->date,
						$monthlyDate
					] )->count();
				}
				break;
				case 'Quarterly':
				$quarterlyFieldVisits = FieldVisit::where('user_id', $userId)
				->where('targets_id', $target->id)->count();
				if ($field_visit_start_date) {
					$total_quarterly_visits = FieldVisit::where( 'user_id', $userId )
					->whereBetween( 'date', [
						$field_visit_start_date->date,
						$quarterlyDate
					] )->count();
				}
				break;
			}
		}

		$userTargets = UserTarget::with('targets')->where('user_id', $userId)->get();

		$visitReports = array();
		$visitCategories = VisitCategory::all();
		foreach($visitCategories as $i => $category){
			$visitReports[$i]['y'] =  FieldVisit::where('user_id', $userId)->where('visit_category_id', $category->id)->count();
			$visitReports[$i]['legendText'] = ucfirst($category->name);
			$visitReports[$i]['label'] = ucfirst($category->name);
		}

		if(Auth::user()->hasRole('marketingOfficer')){
			$sales = array();
			$salesTargets = array();
			$first_sales_date = Sales::where('user_id', Auth::user()->id)->orderBy('created_at', 'asc')->first();
			if ($first_sales_date){
				$weeklyDate = Carbon::parse($first_sales_date->date)->addDays(7)->toDateString();
				$monthlyDate = Carbon::parse($first_sales_date->date)->addDays(30)->toDateString();
				$quarterlyDate = Carbon::parse($first_sales_date->date)->addDays(90)->toDateString();
				foreach($targets as $count => $target){
					$salesTargets[$count]['y'] = UserSales::where('user_id', $userId)->whereHas('targets', function($query) use($target){
						$query->where('target_id', $target->id);
					})->value('total_sales');

					$salesTargets[$count]['label'] = ucfirst($target->name);

					switch ($target->name) {
						case 'Daily':
						$salesTargets[$count]['total_sales'] = Sales::where('user_id', $userId)->where('date',Carbon::now()->toDateString())->whereHas('targets', function($query) use($target){
							$query->where('target_id', $target->id);
						})->sum('received_amount');
						break;
						case 'Weekly':
						$salesTargets[$count]['total_sales'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
						break;
						case 'Monthly':
						$salesTargets[$count]['total_sales'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
						break;
						case 'Quarterly':
						$salesTargets[$count]['total_sales'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
						break;
					}
				}

				foreach($targets as $count => $target){
					switch ($target->name) {
						case 'Daily':
						$sales[$count]['y'] = Sales::where('user_id', $userId)->where('date',Carbon::now()->toDateString())->sum('received_amount');
						break;
						case 'Weekly':
						$sales[$count]['y'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
						break;
						case 'Monthly':
						$sales[$count]['y'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
						break;
						case 'Quarterly':
						$sales[$count]['y'] = Sales::where('user_id', $userId)->whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
						break;
					}
				}
			}
			$totalSalesTargets = UserSales::where('user_id', $userId)->sum('total_sales');
			$totalSales = Sales::where('user_id', $userId)->sum('received_amount');
		}

		if(Auth::user()->hasRole('marketingManager')){
			$salesTargets = array();
			$sales = array();
			$first_sales_date = Sales::orderBy('created_at', 'asc')->first();
			if ($first_sales_date){
				$weeklyDate = Carbon::parse($first_sales_date->date)->addDays(7)->toDateString();
				$monthlyDate = Carbon::parse($first_sales_date->date)->addDays(30)->toDateString();
				$quarterlyDate = Carbon::parse($first_sales_date->date)->addDays(90)->toDateString();
				foreach($targets as $count => $target){
					$salesTargets[$count]['y'] = UserSales::whereHas('targets', function($query) use($target){
						$query->where('target_id', $target->id);
					})->sum('total_sales');

					$salesTargets[$count]['label'] = ucfirst($target->name);

					switch ($target->name) {
						case 'Daily':
						$salesTargets[$count]['total_sales'] = Sales::where('date',Carbon::now()->toDateString())->sum('received_amount');
						break;
						case 'Weekly':
						$salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
						break;
						case 'Monthly':
						$salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
						break;
						case 'Quarterly':
						$salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
						break;
					}
				}
				foreach($targets as $count => $target){
					switch ($target->name) {
						case 'Daily':
						$sales[$count]['y'] = Sales::where('date',Carbon::now()->toDateString())->sum('received_amount');
						break;
						case 'Weekly':
						$sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
						break;
						case 'Monthly':
						$sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
						break;
						case 'Quarterly':
						$sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
						break;
					}
				}
			}
			$totalSalesTargets = UserSales::sum('total_sales');
			$totalSales = Sales::sum('received_amount');
		}

		if(Auth::user()->hasRole('accountant')){
			return view('home', compact('dailyFieldVisits','weeklyFieldVisits','monthlyFieldVisits','quarterlyFieldVisits', 'total_daily_visits', 'total_weekly_visits', 'total_monthly_visits', 'total_quarterly_visits', 'userTargets', 'visitReports'));
		}

		if(Auth::user()->hasRole('client'))
			return view('home');

		if(Auth::user()->hasRole('supporter'))
			return view('home');

		return view('home', compact('dailyFieldVisits','weeklyFieldVisits','monthlyFieldVisits','quarterlyFieldVisits', 'total_daily_visits', 'total_weekly_visits', 'total_monthly_visits', 'total_quarterly_visits', 'userTargets', 'visitReports', 'salesTargets', 'sales', 'totalSalesTargets', 'totalSales'));
	}
}

<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Categories;
use App\Models\Ticket\Agent;
use App\Models\Ticket\Client;
use App\Models\Access\User\User;

class DashboardController extends Controller
{
 	public function dashboard()
 	{
 		$totalTickets = Ticket::count();
 		$openTickets = Ticket::where('completed_at', '=', NULL)->count();
 		$closedTickets = $totalTickets - $openTickets;

 		$categories = Categories::all();
 		$agents = Agent::agentsWithoutAdmin();
 		$clients = Client::clients();

 		//calculates percentage of total distribution per category
 		$categories_share = [];
 		$categoriesPercentage = [];
 		$total = 0;
 		foreach( $categories as $cat )
 		{
 			$categories_share[$cat->name] = $cat->tickets()->count();
 			$total = $total + $categories_share[$cat->name];
 		}

 		foreach( $categories as $cat )
	 		$categoriesPercentage[$cat->name] = ($categories_share[$cat->name]/$total)*100;

	 	//calculates percentage of total distribution per agent
	 	$agents_share = [];
 		$agentsPercentage = [];
 		$total = 0;
 		foreach( $agents as $agent )
 		{
 			$name = $agent->name();
 			$agents_share[$name] = $agent->tickets()->count();
 			$total = $total + $agents_share[$name];
 		}
 		foreach( $agents as $agent )
	 		$agentsPercentage[$agent->name()] = ($agents_share[$agent->name()]/$total)*100;

 		// dd($agentsPercentage);
 		return view('tickets.dashboard')->with('totalTickets', $totalTickets)
 																		->with('openTickets', $openTickets)
 																		->with('closedTickets', $closedTickets)
 																		->with('categories', $categories)
 																		->with('agents', $agents)
 																		->with('clients', $clients)
 																		->with('categoriesPercentage', $categoriesPercentage)
 																		->with('agentsPercentage', $agentsPercentage);
 	}
}

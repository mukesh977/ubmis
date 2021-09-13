<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Categories;
use App\Models\Ticket\Priorities;
use App\Models\Ticket\Status;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketComment;
use App\Models\Ticket\Agent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
  public function create()
  {
  	$categories = Categories::all();
  	$priorities = Priorities::all();

  	return view('tickets.ticket.create')->with('priorities', $priorities)
  																			->with('categories', $categories);
  }

  public function store(Request $request)
  {
  	$validator = Validator::make($request->all(), [
      'subject' => 'required|min:3',
      'description' => 'required|min:6',
      'priority' => 'required|numeric|exists:ticket_priorities,id',
      'category' => 'required|numeric|exists:ticket_categories,id',
    ]);

    if( $validator->fails() )
    {
      return redirect()->back()
                      ->withInput()
                      ->withErrors($validator);
    }

    try
    {
	    $ticket = new Ticket();

	    $ticket->subject = $request['subject'];
	    $ticket->description = $request['description'];
	    $ticket->priority_id = $request['priority'];
	    $ticket->category_id = $request['category'];

	    $ticket->user_id = (!empty($authenticated_user = Auth::user())? $authenticated_user->id : '0');

	    $pendingStatus = Status::where('name', '=', 'pending')->first();
	    if( !empty($pendingStatus) )	
	      $ticket->status_id = $pendingStatus->id;

	    $ticket->autoSelectAgent();

	    $ticket->save();
    }
    catch( Exception $e )
    {
    	request()->session()->flash('unsuccessMessage', 'Failed to create ticket !!!');
    	return redirect()->back();
    }

    request()->session()->flash('successMessage', 'New ticket created successfully !!!');
  	return redirect('tickets');
  }

  public function getActiveTickets()
  {
  	$authenticated_user = Auth::user();

    foreach( $authenticated_user->roles as $role )
      $roles[] = $role->name;

  	$activeTickets = Ticket::with('status', 'agent', 'priority', 'owner', 'category')
                            ->where('completed_at', NULL)
  													->where( function($q) use ($roles, $authenticated_user){
                                  if( in_array('agent', $roles) )
                                      $q->where('agent_id', '=', $authenticated_user->id);
                                  else if( in_array('admin', $roles) )
                                      $q;
                                  else if( in_array('client', $roles) )
                                      $q->where('user_id', '=', $authenticated_user->id);
                              })
                            ->orderBy('created_at', 'DESC')
  													->paginate(24);

  	return view('tickets.ticket.active-tickets')->with('activeTickets', $activeTickets);
  }

  public function getCompletedTickets()
  {
    $authenticated_user = Auth::user();

    foreach( $authenticated_user->roles as $role )
      $roles[] = $role->name;

    $completedTickets = Ticket::with('status', 'agent', 'priority', 'owner', 'category')
                            ->where('completed_at', '!=', NULL)
                            ->where( function($q) use ($roles, $authenticated_user){
                                  if( in_array('agent', $roles) )
                                      $q->where('agent_id', '=', $authenticated_user->id);
                                  else if( in_array('admin', $roles) )
                                      $q;
                                  else if( in_array('client', $roles) )
                                      $q->where('user_id', '=', $authenticated_user->id);
                              })
                            ->orderBy('created_at', 'DESC')
                            ->paginate(24);

    return view('tickets.ticket.completed-tickets')
                ->with('completedTickets', $completedTickets);
  }

  public function show($id='')
  {
    $ticket = Ticket::with('status', 'agent', 'priority', 'owner', 'category', 'comment.user')
                      ->where('id', '=', $id)
                      ->first();
    // dd($ticket);
    $priorities = Priorities::all();
    $categories = Categories::all();
    $statuses = Status::all();
    $agents = Agent::agents();

    return view('tickets.ticket.show')->with('ticket', $ticket)
                                      ->with('priorities', $priorities)
                                      ->with('categories', $categories)
                                      ->with('agents', $agents)
                                      ->with('statuses', $statuses);
  }

  public function complete($id="")
  {
    try
    {
      $ticket = Ticket::where('id', '=', $id)->first();
      $ticket->completed_at = Carbon::now();
      
      $status = Status::where('name', '=', 'solved')->first();

      $ticket->status_id = $status->id;
      $ticket->update();

      $subject = $ticket->subject;
    }
    catch( Exception $e )
    {
      request()->session()->flash('unsuccessMessage', 'Failed to complete ticket !!!');
      return  redirect('/tickets');
    }

    request()->session()->flash('successMessage', 'The ticket '.$subject.' has been completed !!!');
    return  redirect('/tickets');
  }

  public function reopen($id="")
  {
    try
    {
      $ticket = Ticket::where('id', '=', $id)->first();
      $ticket->completed_at = NULL;
      
      $status = Status::where('name', '=', 'pending')->first();
      
      $ticket->status_id = $status->id;
      $ticket->update();

      $subject = $ticket->subject;
    }
    catch( Exception $e )
    {
      request()->session()->flash('unsuccessMessage', 'Failed to reopen ticket !!!');
      return  redirect('/tickets');
    }

    request()->session()->flash('successMessage', 'The ticket '.$subject.' has been reopened !!!');
    return  redirect('/tickets');
  }

  public function update(Request $request, $id='')
  {
    $validator = Validator::make($request->all(), [
      'subject' => 'required|min:3',
      'description' => 'required|min:6',
      'priority' => 'required|numeric|exists:ticket_priorities,id',
      'category' => 'required|numeric|exists:ticket_categories,id',
    ]);

    if( $validator->fails() )
    {
      return redirect()->back()
                      ->withInput()
                      ->withErrors($validator);
    }

    try
    {
      $ticket = Ticket::where('id', '=', $id)->first();

      $ticket->subject = $request['subject'];
      $ticket->description = $request['description'];
      $ticket->status_id = $request['status'];
      $ticket->priority_id = $request['priority'];
      $ticket->agent_id = $request['agent'];
      $ticket->category_id = $request['category'];

      $ticket->update();
    }
    catch( Exception $e )
    {
      request()->session()->flash('unsuccessMessage', 'Failed to modify ticket !!!');
      return redirect()->back();
    }

    request()->session()->flash('successMessage', 'The ticket has been modified !!!');
    return redirect()->back();
  }

  public function destroy( Request $request )
  {
    $ticketId = $request['ticket_id_delete'];

    try
    {
      Ticket::where('id', '=', $ticketId)->delete();
      TicketComment::where('ticket_id', '=', $ticketId)->delete();
    }
    catch( Exception $e )
    {
      request()->session()->flash('unsuccessMessage', 'Failed to delete ticket !!!');
      return redirect('/tickets');
    }

    request()->session()->flash('successMessage', 'Ticket deleted successfully !!!');
    return redirect('/tickets');
  }

  public function searchActive(Request $request)
{
  $subject = $request->keyword;
  $user = Auth()->user()->id;
  $authenticated_user = Auth::user();

  foreach( $authenticated_user->roles as $role )
    $roles[] = $role->name;

  $activeTickets = Ticket::with('status', 'agent', 'priority', 'owner', 'category')
  ->join('ticket_categories', 'tickets.category_id', 'ticket_categories.id')
  ->join('ticket_priorities', 'tickets.priority_id', 'ticket_priorities.id')
  ->join('ticket_statuses', 'tickets.status_id', 'ticket_statuses.id')

  ->where( function($q) use ($subject){
      $q->where('subject', 'like', '%'.$subject.'%')
        ->orWhere('description', 'like', '%'.$subject.'%')
        ->orWhere('ticket_categories.name', 'like', '%'.$subject.'%')
        ->orWhere('ticket_priorities.name', 'like', '%'.$subject.'%')
        ->orWhere('ticket_statuses.display_name', 'like', '%'.$subject.'%');;
  })

  ->where('completed_at', NULL)
  ->where( function($q) use ($roles, $authenticated_user){
            if( in_array('agent', $roles) )
                $q->where('agent_id', '=', $authenticated_user->id);
            else if( in_array('admin', $roles) )
                $q;
            else if( in_array('client', $roles) )
                $q->where('user_id', '=', $authenticated_user->id);
        })
  ->paginate(24);
  return view('tickets.ticket.active-tickets', compact('activeTickets','subject'));
}

public function searchCompleted(Request $request)
{
  $subject = $request->keyword;
  $user = Auth()->user()->id;

  $authenticated_user = Auth::user();

  foreach( $authenticated_user->roles as $role )
    $roles[] = $role->name;

  $completedTickets = Ticket::with('status', 'agent', 'priority', 'owner', 'category')
  ->join('ticket_categories', 'tickets.category_id', 'ticket_categories.id')
  ->join('ticket_priorities', 'tickets.priority_id', 'ticket_priorities.id')
  ->join('ticket_statuses', 'tickets.status_id', 'ticket_statuses.id')

  ->where( function($q) use ($subject){
      $q->where('subject', 'like', '%'.$subject.'%')
        ->orWhere('description', 'like', '%'.$subject.'%')
        ->orWhere('ticket_categories.name', 'like', '%'.$subject.'%')
        ->orWhere('ticket_priorities.name', 'like', '%'.$subject.'%')
        ->orWhere('ticket_statuses.display_name', 'like', '%'.$subject.'%');;
  })
  
  ->where('completed_at', '!=',  NULL)
  ->where( function($q) use ($roles, $authenticated_user){
      if( in_array('agent', $roles) )
          $q->where('agent_id', '=', $authenticated_user->id);
      else if( in_array('admin', $roles) )
          $q;
      else if( in_array('client', $roles) )
          $q->where('user_id', '=', $authenticated_user->id);
  })
  ->paginate(24);

  // dd($completedTickets);
  return view('tickets.ticket.completed-tickets', compact('completedTickets', 'subject'));
}
}

<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket\TicketComment;
use App\Models\Ticket\Ticket;

class CommentController extends Controller
{
  public function store(Request $request)
  {
 		$validator = Validator::make($request->all(), [
      'comment' => 'required|min:6',
      'ticketId' => 'required|numeric|exists:tickets,id',
    ]);

    if( $validator->fails() )
    {
      return redirect()->back()
                      ->withInput()
                      ->withErrors($validator);
    }

    try
    {
    	$comment = new TicketComment();

    	$comment->content = $request['comment'];
    	$comment->user_id = Auth::user()->id;
    	$comment->ticket_id = $request['ticketId'];

    	$comment->save();

    	$ticket = Ticket::where('id', '=', $comment->ticket_id)->first();
    	$ticket->updated_at = $comment->created_at;
    	$ticket->update();
    }
    catch(Exception $e)
    {
    	request()->session()->flash('unsuccessMessage', 'Failed to add comment !!!');
    	return redirect()->back();
    }
  	
  	request()->session()->flash('successMessage', 'Comment has been successfully added !!!');
  	return redirect()->back();
  }
}

<?php

namespace App\Http\Controllers\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification\TimelyNotification;
use DateTime;

class TaskController extends Controller
{
    public function getDueTasks()
    {
    	$dueTasks = TimelyNotification::with('company', 'service')
    									->where('task_done', '=', 0)
    									->orderBy('created_at', 'DESC')
    									->paginate(24);

        $currentDate = new DateTime(date('Y-m-d'));

    	return view('tasks.due-tasks')->with('dueTasks', $dueTasks)
    									->with('currentDate', $currentDate);
    }

    public function markTaskAsComplete(Request $request)
    {
    	try
    	{
	    	TimelyNotification::where('id', '=', $request['task_id'])->update(['task_done' => 1]);
    	}
    	catch( \Exception $e )
    	{
    		request()->session()->flash('unsuccessMessage', 'Failed to mark this task as complete !!!');
    		return redirect()->back();
    	}

    	request()->session()->flash('successMessage', 'Marked this task as complete successfully !!!');
    	return redirect()->back();
    }

    public function getCompletedTasks()
    {
    	$completedTasks = TimelyNotification::with('company', 'service')
    									->where('task_done', '=', 1)
    									->orderBy('created_at', 'DESC')
    									->paginate(24);

        $currentDate = new DateTime(date('Y-m-d'));
    	// dd($dueTasks);

    	return view('tasks.completed-task')->with('completedTasks', $completedTasks)
    									->with('currentDate', $currentDate);
    }

    public function unmarkTaskAsComplete(Request $request)
    {
    	try
    	{
	    	TimelyNotification::where('id', '=', $request['task_id'])->update(['task_done' => 0]);
    	}
    	catch( \Exception $e )
    	{
    		request()->session()->flash('unsuccessMessage', 'Failed to mark this task as complete !!!');
    		return redirect()->back();
    	}

    	request()->session()->flash('successMessage', 'Marked this task as complete successfully !!!');
    	return redirect()->back();
    }
}

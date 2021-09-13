<?php

namespace App\Http\Controllers\Targets;

use App\Http\Requests\Targets\UserTargetRequest;
use App\Models\Targets\Target;
use App\Models\Targets\UserTarget;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class UserTargetController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$userTargets = UserTarget::with('users', 'targets')->paginate(10);

	    return view('targets.index', compact('userTargets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    	$users = (new UserTarget())->getTargetedUsers();

	    $targets = Target::all();

        return view('targets.create-targets', compact('users', 'targets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserTargetRequest $request)
    {
        $data = new UserTarget();
        $data->user_id = $request->user_id;
        $data->target_id = $request->target_id;
        $data->total_target = $request->total_target;
        $data->created_by = Auth::user()->first_name.' '.Auth::user()->last_name;
        $data->save();

        return redirect()->route('users-targets.index')->with('success', 'Target Set Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userTarget = UserTarget::with('users', 'targets')->where('id', $id)->first();

        return view('targets.show-targets', compact('userTarget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $users = (new UserTarget())->getTargetedUsers();
        $userTargets = UserTarget::with('users', 'targets')->where('id', $id)->first();
        $targets = Target::all();

        return view('targets.edit-targets', compact('users', 'userTargets', 'targets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTargetRequest $request, $id)
    {
        $userTarget = UserTarget::find($id);
        $datas = [
        	'user_id' => $request->user_id,
	        'target_id' => $request->target_id,
	        'total_target' => $request->total_target,
        ];

        $userTarget->update($datas);

        return redirect()->route('users-targets.index')->with('success', 'Target Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserTarget::where('id', $id)->delete();

        return response()->json(['success' => 'Successfully Deleted The Target.']);
    }

    public function dailyUserTargets()
    {
    	$target = Target::where('name', '=', 'Daily')->first();
		$userTargets = $this->getUsersTargets($target);

		return view('targets.index', compact('userTargets'));
    }

    public function weeklyUserTargets()
    {
	    $target = Target::where('name', '=', 'Weekly')->first();
	    $userTargets = $this->getUsersTargets($target);

	    return view('targets.index', compact('userTargets'));
    }

    public function quarterlyUserTargets()
    {
	    $target = Target::where('name', '=', 'Quarterly')->first();
	    $userTargets = $this->getUsersTargets($target);

	    return view('targets.index', compact('userTargets'));
    }

    public function monthlyUserTargets()
    {
	    $target = Target::where('name', '=', 'Monthly')->first();
	    $userTargets = $this->getUsersTargets($target);

	    return view('targets.index', compact('userTargets'));
    }

    private function getUsersTargets($target)
    {
	    $user_id = Auth::user()->id;
	    $userTargets = UserTarget::with('users', 'targets')
	                             ->where('target_id', $target->id)
	                             ->where('user_id', $user_id)
	                             ->get();

	    return $userTargets;
    }
}

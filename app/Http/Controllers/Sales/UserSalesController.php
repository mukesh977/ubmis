<?php

namespace App\Http\Controllers\Sales;

use App\Http\Requests\Sales\UserSalesRequest;
use App\Models\Sales\UserSales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Targets\Target;

class UserSalesController extends Controller
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
    	$userSales = UserSales::with('users', 'targets')->paginate(10);

        return view('sales.sales-target.index', compact('userSales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$users = (new UserSales())->getTargetedSaleUsers();

	    $targets = Target::all();

	    return view('sales.sales-target.create-sales', compact('users', 'targets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserSalesRequest $request)
    {
	    $data = new UserSales();
	    $data->user_id = $request->user_id;
	    $data->target_id = $request->target_id;
	    $data->total_sales = $request->total_sales;
	    $data->created_by = Auth::user()->first_name.' '.Auth::user()->last_name;
	    $data->save();

	    return redirect()->route('users-sales.index')->with('success', 'Target Set Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userSale = UserSales::with('users', 'targets')->where('id', $id)->first();

        return view('sales.sales-target.show-sales', compact('userSale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $users = (new UserSales())->getTargetedSaleUsers();

    	$userSales = UserSales::with('users', 'targets')
		                ->where('id', $id)->first();

	    $targets = Target::all();

	    return view('sales.sales-target.edit-sales', compact('users', 'targets', 'userSales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserSalesRequest $request, $id)
    {
        $userSales = UserSales::find($id);
        $datas = [
        	'user_id' => $request->user_id,
	        'target_id' => $request->target_id,
	        'total_sales' => $request->total_sales,
        ];

        $userSales->update($datas);

        return redirect()->route('users-sales.index')->with('success', 'User Sales Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserSales::where('id', $id)->delete();

        return response()->json(['Success' => 'User Sales Delete Success']);
    }

    public function dailyUserSales()
    {
	    $target = Target::where('name', '=', 'Daily')->first();
	    $userSales = $this->getUserSales($target);

	    return view('sales.sales-target.index', compact('userSales'));
    }

    public function weeklyUserSales()
    {
	    $target = Target::where('name', '=', 'Weekly')->first();
	    $userSales = $this->getUserSales($target);

	    return view('sales.sales-target.index', compact('userSales'));
    }

    public function monthlyUserSales()
    {
	    $target = Target::where('name', '=', 'Monthly')->first();
	    $userSales = $this->getUserSales($target);

	    return view('sales.sales-target.index', compact('userSales'));
    }

    public function quarterlyUserSales()
    {
	    $target = Target::where('name', '=', 'Quarterly')->first();
		$userSales = $this->getUserSales($target);

	    return view('sales.sales-target.index', compact('userSales'));
    }

    private function getUserSales($target)
    {
	    $user_id = Auth::user()->id;
	    $userSales = UserSales::with('users', 'targets')
	                          ->where('target_id', $target->id)
	                          ->where('user_id', $user_id)
	                          ->get();

	    return $userSales;
    }
}

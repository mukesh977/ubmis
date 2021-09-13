<?php

namespace App\Http\Controllers\Sales;

use App\Http\Requests\Sales\SalesRequest;
use App\Models\Company\Company;
use App\Models\FieldVisit\FieldVisit;
use App\Models\Sales\Sales;
use App\Models\Sales\SalesCategory;
use App\Models\Targets\Target;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class SalesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('role:marketingOfficer|marketingManager|admin');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(Auth::user()->hasRole('marketingOfficer')){
		    $userSales = Sales::with('salesCategories', 'companies','targets')->where('user_id', Auth::user()->id)
		                      ->get();
	    }else{
    		$userSales = Sales::with('salesCategories', 'companies','targets')
		                      ->get();
	    }

        return view('sales.users-sales.index', compact('userSales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$salesCategories = SalesCategory::all();
    	$companies = Company::all();
    	$targets = Target::all();

        return view('sales.users-sales.users-sales-create', compact('salesCategories', 'companies', 'targets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesRequest $request)
    {
	    $target = Target::where('name', '=', 'Daily')->first();
    	$company = Company::find($request->company_id);
        $sales = new Sales();
        $sales->user_id = Auth::user()->id;
        $sales->company_id = $request->company_id;
        $sales->sales_category_id = $request->sales_category_id;
        $sales->date = date("Y-m-d", strtotime($request->date));
        $sales->received_amount = $request->received_amount;
        $sales->target_id = $target->id;
        $sales->office_name = $company->name;
        $sales->save();

        return redirect()->route('sales.index')->with('success', 'Sales created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // You can show sales form here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $salesCategories = SalesCategory::all();
	    $targets = Target::all();
	    $companies = Company::all();

	    $sale = Sales::find($id);

	    return view('sales.users-sales.users-sales-edit', compact('salesCategories', 'companies', 'sale', 'targets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalesRequest $request, $id)
    {
	    $target = Target::where('name', '=', 'Daily')->first();
	    $company = Company::find($request->comany_id);
	    $sale = Sales::find($id);
	    $datas = [
		    'user_id' => Auth::user()->id,
		    'comany_id' => $request->comany_id,
		    'sales_category_id' => $request->sales_category_id,
		    'date' => date("Y-m-d", strtotime($request->date)),
		    'received_amount' => $request->received_amount,
		    'target_id' => $target->id,
		    'office_name' => $company->name,
	    ];

	    $sale->update($datas);

	    return redirect()->route('sales.index')->with('success', 'Successfully Updated this sale.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sales::where('id', $id)->delete();

        return response()->json(['success' => 'User Sale successfully deleted.']);
    }
}

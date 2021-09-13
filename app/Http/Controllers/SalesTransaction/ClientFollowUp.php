<?php

namespace App\Http\Controllers\SalesTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Calendar\ClientFollowUpModel;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Validator;


class ClientFollowUp extends Controller
{
    public function index()
    {
        $companies = Company::all();
        $clientFollowUps = ClientFollowUpModel::paginate(24);
        
        return view('calendar.index')->with('clientFollowUps', $clientFollowUps)
                                        ->with('companies', $companies);
    }


    public function create()
    {
    	$companies = Company::all();

    	return view('calendar.create')->with('companies', $companies);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	        'officeName' => 'required|numeric',
	        'date' => 'required|string',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        try
        {
        	$clientFollowUp = new ClientFollowUpModel();

        	$clientFollowUp->company_id = $request['officeName'];
        	$clientFollowUp->follow_up_date = $request['date'];

        	$clientFollowUp->save();
        }
        catch( \Exception $e)
        {
            return redirect()->back()->with('successMessage', 'Failed to add Client follow up !!!');

        }
        
    	return redirect()->back()->with('successMessage', 'Client follow up added successfully !!!');


    }

    public function edit($id = '')
    {
        $companies = Company::all();
        $editFollowUp = ClientFollowUpModel::where('id', '=', $id)->first();

        // dd($editFollowUp);

        return view('calendar.edit')->with('companies', $companies)
                                        ->with('editFollowUp', $editFollowUp);
    }

    public function update($id = '', Request $request)
    {
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|numeric',
            'date' => 'required|string',
            ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        try
        {
            $clientFollowUp = ClientFollowUpModel::where('id', '=', $id)->first();

            $clientFollowUp->company_id = $request['officeName'];
            $clientFollowUp->follow_up_date = $request['date'];

            $clientFollowUp->update();
        }
        catch( \Exception $e)
        {
            return redirect()->back()->with('successMessage', 'Failed to update Client follow up !!!');

        }
        
        return redirect()->back()->with('successMessage', 'Client follow up update successfully !!!');

    }
}

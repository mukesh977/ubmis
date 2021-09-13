<?php

namespace App\Http\Controllers\Package;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Package\AmcPackage;

class AmcPackageController extends Controller
{
	public function index()
	{
		$amcPackages = AmcPackage::paginate(24);

		return view('packages.amcPackage.index')->with('amcPackages', $amcPackages);
	}



    public function create()
    {
    	return view('packages.amcPackage.create');
    }


    public function store(Request $request)
    {	
    	$validator = Validator::make($request->all(), [
	        'amcAttributeName' => 'required|string',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

    	try
    	{
	    	$amcPackage = new AmcPackage();

	    	$amcPackage->name = $request['amcAttributeName'];

	    	$slug = preg_replace('/\s+/', '-', strtolower($request['amcAttributeName']));
	    	$amcPackage->slug = $slug;

	    	$amcPackage->save();
    	}
    	catch( \Exception $e )
    	{
	    	return redirect()->back()->with('unsuccessMessage', 'Failed to store AMC 
	    	Attribute !!!');
    	}
    	return redirect()->back()->with('successMessage', 'AMC Attribute created successfully !!!');
    }


    public function edit($id = '')
    {
    	$editAmcPackage = AmcPackage::where('id', '=', $id)->first();

    	return view('packages.amcPackage.edit')->with('editAmcPackage', $editAmcPackage);
    }


    public function update(Request $request, $id = '')
    {
    	try
    	{
	    	$editAmcPackage = AmcPackage::where('id', '=', $id)->first();

	    	$editAmcPackage->name = $request['amcAttributeName'];

	    	$editAmcPackage->update();
    	}
    	catch( \Exception $e )
    	{
    		return redirect()->back()->with('unsuccessMessage', 'Failed to update amc attribute !!!');
    	}

    	return redirect()->back()->with('successMessage', 'AMC Attribute updated successfully !!!');
    }

}

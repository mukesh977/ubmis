<?php

namespace App\Http\Controllers\Package;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package\SeoPackage;
use Illuminate\Support\Facades\Validator;

class SeoPackageController extends Controller
{
	public function index()
	{
		$seoPackages = SeoPackage::paginate(24);

		return view('packages.seoPackage.index')->with('seoPackages', $seoPackages);
	}


    public function create()
    {
    	return view('packages.seoPackage.create');
    }


    public function store(Request $request)
    {	
    	$validator = Validator::make($request->all(), [
	        'seoPackageName' => 'required|string',
	        'price' => 'required|numeric'
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

    	try
    	{
	    	$seoPackage = new SeoPackage();

	    	$seoPackage->name = $request['seoPackageName'];
	    	$seoPackage->price = $request['price'];

	    	$slug = preg_replace('/\s+/', '-', strtolower($request['seoPackageName']));
	    	$seoPackage->slug = $slug;

	    	$seoPackage->save();
    	}
    	catch( \Exception $e )
    	{
	    	return redirect()->back()->with('unsuccessMessage', 'Failed to store Seo Package !!!');
    	}
    	return redirect()->back()->with('successMessage', 'Seo Package created successfully !!!');
    }


    public function edit($id = '')
    {
    	$editSeoPackage = SeoPackage::where('id', '=', $id)->first();

    	return view('packages.seoPackage.edit')->with('editSeoPackage', $editSeoPackage);
    }


    public function update(Request $request, $id = '')
    {
    	try
    	{
	    	$editSeoPackage = SeoPackage::where('id', '=', $id)->first();

	    	$editSeoPackage->name = $request['seoPackageName'];
	    	$editSeoPackage->price = $request['price'];

	    	$editSeoPackage->update();
    	}
    	catch( \Exception $e )
    	{
    		return redirect()->back()->with('unsuccessMessage', 'Failed to update seo package !!!');
    	}

    	return redirect()->back()->with('successMessage', 'Seo Package updated successfully !!!');
    }
}

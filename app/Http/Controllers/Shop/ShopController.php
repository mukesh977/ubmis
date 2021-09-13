<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PurchaseTransaction\Shop;
use App\Models\ContactNumber\ContactNumber;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function store(Request $request)
    {
    	if($request->ajax())
    	{
    		
	    		$shop = new Shop();

	    		$shop->name = $request->name;
	    		$shop->address = $request->address;

	    		$shop->save();


	    		foreach( $request['contactNumbers'] as $contactNumber)
	    		{
		    		$cN = new ContactNumber();

		    		$cN->contact_number = $contactNumber;
		    		$cN->contact_number_id = $shop->id;
		    		$cN->contact_number_type = "shop";

		    		$cN->save();

	    		}

		    	return response()->json(['data' => $shop, 'message' => 'New shop added successfully !!!']);

    		
    	}
    }

    public function index()
    {
    	$listShops = Shop::with('contactNumbers')->paginate(24);
    	// dd($listShops);

    	return view('shop.list-shop')->with('listShops', $listShops);
    }

    public function create()
    {
    	return view('shop.add-shop');
    }

    public function storeShop(Request $request)
    {
    	 $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'contactNumber.*' => 'required|numeric',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

       
	        $shop = new Shop();

	        $shop->name = $request['name'];
	        $shop->address = $request['address'];

	        $shop->save();

	        $count = count($request['contactNumber']);

	        for( $i = 0; $i < $count; $i++ )
	        {
	        	$contact = new ContactNumber();

		        $contact->contact_number = $request['contactNumber'][$i];
		        $contact->contact_number_id = $shop->id;
		        $contact->contact_number_type = "shop";

		        $contact->save();
	        	
	        }
        

        return redirect()->back()->with('successMessage', 'New shop added successfully !!!');
    }

    public function edit($id = '')
    {
    	$editShop = Shop::with('contactNumbers')
    						->where('id', '=', $id)
    						->first();
    	// dd($editShop);

    	return view('shop.edit-shop')->with('editShop', $editShop);
    }

    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'contactNumber.*' => 'required|numeric',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

    	try
    	{
	    	$editShop = Shop::where('id', '=', $request['shopId'])
	    						->first();

	    	$editShop->name =  $request['name'];
	    	$editShop->address = $request['address'];

	    	$editShop->update();

	    	ContactNumber::where('contact_number_type', '=', 'shop')
	    					->where('contact_number_id', '=', $editShop->id)
	    					->delete();

	    	$count = count($request['contactNumber']);

	    	for( $i = 0; $i < $count; $i++ )
	    	{
	    		$editContact = new ContactNumber();

	    		$editContact->contact_number = $request['contactNumber'][$i];
	    		$editContact->contact_number_id = $editShop->id;
	    		$editContact->contact_number_type = "shop";

	    		$editContact->save();
	    	}
    		
    	}
    	catch( \Exception $e )
    	{
    		return redirect()->back()->with('unsuccessMessage', 'Failed to update shop !!!');
    	}

    	return redirect()->back()->with('successMessage', 'Shop edited successfully !!!');
    }


    public function destroy(Request $request)
    {
    	$deleteShopId = $request['shop_id_delete'];

    	try
    	{
	    	Shop::where('id', '=', $deleteShopId)->delete();

	    	ContactNumber::where('contact_number_id', '=', $deleteShopId)
	    					->where('contact_number_type', '=', 'shop')
	    					->delete();
    	}
    	catch( \Exception $e )
    	{
    		return redirect()->back()->with('unsuccessMessage', 'Failed to delete shop !!!');
    	}

    	return redirect()->back()->with('successMessage', 'Shop deleted successfully !!!');
    }


    public function show(Request $request)
    {
    	if( $request->ajax() )
    	{
    		$shop = Shop::with('contactNumbers')->where('id', '=', $request['id'])->first();

    		return Response($shop);
    	}
    }


    public function searchShop(Request $request)
    {
        $shopName = $request['shopName'];

        $searchedShops = Shop::with('contactNumbers')
                                ->where('name', 'LIKE', '%' . $shopName . '%')
                                ->paginate(24);

        $searchedShops->appends(['shopName' => $shopName]);

        return view('shop.searched-shop')->with('searchedShops', $searchedShops)
                                        ->with('searchedWord', $shopName);
    }


}

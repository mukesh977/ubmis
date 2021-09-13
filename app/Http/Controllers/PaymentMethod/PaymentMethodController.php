<?php

namespace App\Http\Controllers\PaymentMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\PaymentMethod\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	$listPaymentMethod = PaymentMethod::paginate(24);

    	return view('paymentMethod.list-payment-method')->with('listPaymentMethod', $listPaymentMethod);
    }

    public function create()
    {
    	return view('paymentMethod.create-payment-method');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'description' => 'required|string',
	    ]);

      if( $validator->fails() )
      {
          return redirect()->back()
                          ->withInput()
                          ->withErrors($validator);
      }

      try
      {
	      $paymentMethod = new PaymentMethod();

	      $paymentMethod->name = $request['name'];
	      $paymentMethod->description = $request['description'];

	      $paymentMethod->save();
      }
      catch( \Exception $e )
      {
      	return redirect()->back()->with('unsuccessMessage', 'Failed to create payment method !!!');
      }

      return redirect()->back()->with('successMessage', 'Payment method created successfully !!!');
    }


    public function edit( $id = '' )
    {
    	$editPaymentMethod = PaymentMethod::where('id', '=', $id)->first();

    	return view('paymentMethod.edit-payment-method')->with('editPaymentMethod', $editPaymentMethod);
    }

    public function update( Request $request, $id = '' )
    {
    	$validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'description' => 'required|string',
	    ]);

      if( $validator->fails() )
      {
          return redirect()->back()
                          ->withInput()
                          ->withErrors($validator);
      }

      try
      {
	      $paymentMethod = PaymentMethod::where('id', '=', $id)->first();

	      $paymentMethod->name = $request['name'];
	      $paymentMethod->description = $request['description'];

	      $paymentMethod->update();
      }
      catch( \Exception $e )
      {
      	return redirect()->back()->with('unsuccessMessage', 'Failed to update payment method !!!');
      }

      return redirect()->back()->with('successMessage', 'Payment method updated successfully !!!');
    }


    public function destroy(Request $request)
   	{
   		$paymentMethodId = $request['method_id_delete'];

   		try
   		{
   			PaymentMethod::where('id', '=', $paymentMethodId)->delete();
   		}
   		catch( \Exception $e )
   		{
   			return redirect()->back()->with('unsuccessMessage', 'Failed to delete payment method !!!');
   		}

   		return redirect()->back()->with('successMessage', 'Payment method deleted successfully !!!');
   	}
}

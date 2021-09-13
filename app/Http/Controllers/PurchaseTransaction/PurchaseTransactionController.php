<?php

namespace App\Http\Controllers\PurchaseTransaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PurchaseTransaction\Shop;
use App\Models\PurchaseTransaction\PurchaseTransaction;
use App\Models\PurchaseTransaction\PurchaseTransactionItem;
use App\Models\PurchaseTransaction\PurchaseInstallmentPayment;
use App\Models\RequestedTransaction\RequestedSalesTransaction;
use App\Models\RequestedTransaction\RequestedSalesTransactionItem;
use App\Models\RequestedTransaction\RequestedSalesInstallmentPayment;
use App\Models\PaymentMethod\PaymentMethod;


class PurchaseTransactionController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:accountant');
    }


    public function create( $id = "" )
    {
    	$shops = Shop::all();
    	$paymentMethods = PaymentMethod::all();
    	// dd($shops);

        if( $id == "" )
        {
        	try
        	{
    	    	$lstPurchaseId = PurchaseTransaction::orderBy('id', 'DESC')->first()->id;
        	}
        	catch( \Exception $e ){ }

        	if( empty($lstPurchaseId) )
        		$lastPurchaseId = 1;
        	else
        		$lastPurchaseId = $lstPurchaseId + 1;

        	return view('purchaseTransaction.add-purchase')->with('lastPurchaseId', $lastPurchaseId)
        													->with('paymentMethods', $paymentMethods)
        													->with('shops', $shops);
            
        }
        else
        {
            $editPurchase = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment')
                                            ->where('id', '=', $id)
                                            ->first();
        	// dd($editPurchase);

            $lastPurchaseId = 1;

            return view('purchaseTransaction.add-purchase')->with('lastPurchaseId', $lastPurchaseId)
		                                                        ->with('editPurchase', $editPurchase)
		                                                        ->with('paymentMethods', $paymentMethods)
		                                                        ->with('shops', $shops);
                                                        

        }
    
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	        'purchaseCode' => 'required|string',
	        'date' => 'required|string',
	        'shopName' => 'required',
	        // 'shopName' => 'required|numeric|exists:companies,id', needstobechanged

	        'items.*' => 'required',
	        'quantity.*' => 'required|numeric',
	        'unit.*' => 'required|string',
	        'rate.*' => 'required|numeric',
	        'price.*' => 'required|numeric',
	        'paidAmount' => 'required|numeric',
	        'unpaidAmount' => 'required|numeric',
	        'paymentMethod' => 'required|numeric|exists:payment_methods,id',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
       
        }

        $count = count($request['items']);

        if( empty($request['purchaseId']) )
        {
	        try
	        {
		       	$pT = new PurchaseTransaction();

		       	$pT->user_id = Auth::user()->id;
		       	$pT->shop_id = $request['shopName'];
		       	$pT->purchase_code = $request['purchaseCode'];
		       	$pT->date = $request['date'];
		       	$pT->total_amount = $request['totalAmount'];
		       	$pT->total_paid_amount = $request['paidAmount'];
		       	$pT->total_unpaid_amount = $request['unpaidAmount'];

		       	if( $request['totalAmount'] > $request['paidAmount'])
			       	$pT->payment_complete_status = 0;
			    else       	
			       	$pT->payment_complete_status = 1;

			    $pT->save();


			    for( $i = 0; $i < $count; $i++ )
			    {
				    $pTI = new PurchaseTransactionItem();

				    $pTI->purchase_transaction_id = $pT->id;
				    $pTI->items = $request['items'][$i];
				    $pTI->rate = $request['rate'][$i];
				    $pTI->quantity = $request['quantity'][$i];
				    $pTI->unit = $request['unit'][$i];
				    $pTI->total_price = $request['price'][$i];
			    	
			    	$pTI->save();
			    }

			    $pIP = new PurchaseInstallmentPayment();

			    $pIP->purchase_transaction_id = $pT->id;
			    $pIP->user_id = Auth::user()->id;
			    $pIP->paid_amount = $request['paidAmount'];        
			    $pIP->payment_method = $request['paymentMethod'];

			    $pIP->save();
	        	
	        }
	        catch( \Exception $e )
			    {
			        return redirect()->back()->with('unsuccessMessage', 'Failed to add new purchase transaction !!!');
			    }
        	
        	return redirect()->back()->with('successMessage', 'New purchase transaction added successfully !!!');
        }
        else
        {
        	try
        	{
	        	$rPT = new RequestedSalesTransaction();

		       	$rPT->r_actual_purchase_id = $request['purchaseId'];
	        	$rPT->r_user_id = Auth::user()->id;
		       	$rPT->r_shop_id = $request['shopName'];
		       	$rPT->r_purchase_code = $request['purchaseCode'];
		       	$rPT->r_date = $request['date'];
		       	$rPT->r_total_amount = $request['totalAmount'];
		       	$rPT->r_total_paid_amount = $request['paidAmount'];
		       	$rPT->r_total_unpaid_amount = $request['unpaidAmount'];
		       	$rPT->r_operation = "editPurchase";
		       	$rPT->completed = 0;

		       	if( $request['totalAmount'] > $request['paidAmount'])
			       	$rPT->r_payment_complete_status = 0;
				    else       	
			       	$rPT->r_payment_complete_status = 1;

			       $rPT->save();

			       for( $i = 0; $i < $count; $i++ )
			       {
			       	$rPTI = new RequestedSalesTransactionItem();

			       	$rPTI->r_transaction_id = $rPT->id;
			       	$rPTI->r_items = $request['items'][$i];
			       	$rPTI->r_quantity = $request['quantity'][$i];
			       	$rPTI->r_unit = $request['unit'][$i];
			       	$rPTI->r_rate = $request['rate'][$i];
			       	$rPTI->r_total_price = $request['price'][$i];

			       	$rPTI->save();
			       }

			       $pIP = PurchaseInstallmentPayment::where('purchase_transaction_id', '=', $request['purchaseId'])->get();
			       $count2 = $pIP->count();

			       for( $i = 0; $i < $count2; $i++ )
			       {
			       	$rPIP = new RequestedSalesInstallmentPayment();

			       	$rPIP->r_transaction_id = $rPT->id;
			       	$rPIP->r_user_id = Auth::user()->id;
			       	$rPIP->r_paid_amount = $pIP[$i]->paid_amount;
			       	$rPIP->r_payment_method = $pIP[$i]->payment_method;

			       	$rPIP->save();
			       }
        	}
        	catch( \Exception $e )
          {
              return redirect('/add-purchase')->with('unsuccessMessage', 'Failed to send data to administrator for editing purchase transaction !!!');
          }

          return redirect('/add-purchase')->with('successMessage', 'Data has been sent to administrator for editing purchase transaction !!!');

        }

    }


    public function show()
    {
    	$paginationNumber = 24;

        $purchaseTransactions = PurchaseTransaction::with('shop')
        											->orderBy('date', 'DESC')
                                                	->orderBy('payment_complete_status', 'ASC')
                                                	->paginate($paginationNumber);
                                                

        return view('purchaseTransaction.list-purchases')->with('purchaseTransactions', $purchaseTransactions)
                                                    ->with('paginationNumber', $paginationNumber);
    
    }

    public function destroy(Request $request)
    {
    	$purchaseId = $request['purchase_id_delete'];

      $deletePurchase = PurchaseTransaction::with('PurchaseTransactionItem', 'PurchaseInstallmentPayment')->where('id','=', $purchaseId)->first();

      
          $requestedPurchase = new RequestedSalesTransaction();

          $requestedPurchase->r_actual_purchase_id = $deletePurchase->id;
          $requestedPurchase->r_purchase_code = $deletePurchase->purchase_code;
          $requestedPurchase->r_date = $deletePurchase->date;
          $requestedPurchase->r_shop_id = $deletePurchase->shop_id;
          $requestedPurchase->r_user_id = Auth::user()->id;
          $requestedPurchase->r_total_amount = $deletePurchase->total_amount;
          $requestedPurchase->r_total_paid_amount = $deletePurchase->total_paid_amount;
          $requestedPurchase->r_total_unpaid_amount = $deletePurchase->total_unpaid_amount;
          $requestedPurchase->r_payment_complete_status = $deletePurchase->payment_complete_status;
          $requestedPurchase->r_operation = "deletePurchase";
          $requestedPurchase->completed = 0;

          $requestedPurchase->save();


          $totalData = $deletePurchase->purchaseTransactionItem->count();

          for( $i = 0; $i < $totalData; $i++ )
          {
              $rPurchaseTransactionsItem = new RequestedSalesTransactionItem();

              $rPurchaseTransactionsItem->r_transaction_id = $requestedPurchase->id;
              $rPurchaseTransactionsItem->r_items = $deletePurchase->purchaseTransactionItem[$i]->items;
              $rPurchaseTransactionsItem->r_quantity = $deletePurchase->purchaseTransactionItem[$i]->quantity;
              $rPurchaseTransactionsItem->r_rate = $deletePurchase->purchaseTransactionItem[$i]->rate;
              $rPurchaseTransactionsItem->r_total_price = $deletePurchase->purchaseTransactionItem[$i]->total_price;

              $rPurchaseTransactionsItem->save();
          }

          $totald = $deletePurchase->purchaseInstallmentPayment->count();

          for( $i = 0; $i < $totald; $i++ )
          {
              $rPurchaseInstallmentPayment = new RequestedSalesInstallmentPayment();


              $rPurchaseInstallmentPayment->r_transaction_id = $requestedPurchase->id;

              $rPurchaseInstallmentPayment->r_user_id = $deletePurchase->purchaseInstallmentPayment[$i]->user_id;

              $rPurchaseInstallmentPayment->r_paid_amount = $deletePurchase->purchaseInstallmentPayment[$i]->paid_amount;

              $rPurchaseInstallmentPayment->r_payment_method = $deletePurchase->purchaseInstallmentPayment[$i]->payment_method;


              $rPurchaseInstallmentPayment->save();
          }
               
          
      return redirect()->back()->with('successMessage', 'Data has been sent to administrator for deleting purchase transaction !!!');
  }


  public function ajaxShow(Request $request)
  {
  	if( $request->ajax() )
        {
            $purchase = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment', 'shop')->where('id','=', $request->id)->first();
            
            return Response($purchase);
        }
  }


  public function purchasePay( $id )
  {
  	$paymentMethods = PaymentMethod::all();
    $purchase = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment', 'shop')
                                        ->where('id', '=', $id)
                                        ->first();
    // dd($purchase);


    return view('purchaseTransaction.purchase-pay')->with('purchase', $purchase)
    												->with('paymentMethods', $paymentMethods);
                                                
  }


  public function purchasePayProcessing(Request $request)
  {
  	$payingAmount = $request['payAmount'];
    $purchaseId = $request['purchaseId'];
    $paymentMethod = $request['pMethod'];

    try
    {
	  	$purchaseInstallmentPayment = new PurchaseInstallmentPayment();

	    $purchaseInstallmentPayment->purchase_transaction_id = $purchaseId;
	    $purchaseInstallmentPayment->user_id = Auth::user()->id;
	    $purchaseInstallmentPayment->paid_amount = $payingAmount;
	    $purchaseInstallmentPayment->payment_method = $paymentMethod;

	    $purchaseInstallmentPayment->save();

	    $total_paid_amount = PurchaseInstallmentPayment::where('purchase_transaction_id', '=', $purchaseId)->sum('paid_amount');

	    $pt = PurchaseTransaction::where('id', '=', $purchaseId)->first();

	    $total_amount = $pt->total_amount;

	    $pt->total_paid_amount = $total_paid_amount;
	    $pt->total_unpaid_amount = $total_amount - $total_paid_amount;

	    if( $total_amount == $total_paid_amount )
	        $pt->payment_complete_status = 1;
	    else
	        $pt->payment_complete_status = 0;

	    $pt->update();
    	
    }
    catch( \Exception $e )
    {
	    return redirect()->back()->with('unsuccessMessage', 'Failed to update payment !!!');
    }
	

	return redirect()->back()->with('successMessage', 'Payment has been made successfully !!!');
  }


  public function editPayForm( $id )
  {
  	$purchase = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment')
                                            ->where('id', '=', $id)
                                            ->first();

    $paymentMethods = PaymentMethod::all();

    $editPurchase = 1;

    return view('purchaseTransaction.purchase-pay')->with('purchase', $purchase)
    													->with('paymentMethods', $paymentMethods)
			                                            ->with('editPurchase', $editPurchase);
                                            
  }


  public function editPay(Request $request)
  {
  	$validator = Validator::make($request->all(), [

      'iPaidAmount.*' => 'required|numeric',
      'iPaymentMethod.*' => 'required|numeric|exists:payment_methods,id',
      ]);

	  if( $validator->fails() )
	  {
	      return redirect()->back()
	                      ->withInput()
	                      ->withErrors($validator);
	  }   


	  $purchaseId = $request['purchaseId'];

	  try
	  {
	      $pT = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment')
	                              ->where('id', '=', $purchaseId)
	                              ->first();

	      $r_total_paid_amount = 0;

	      $rST = new RequestedSalesTransaction();

	      $rST->r_actual_purchase_id = $purchaseId;
	      $rST->r_user_id = Auth::user()->id;
	      $rST->r_shop_id = $pT->shop_id;
	      $rST->r_purchase_code = $pT->purchase_code;
	      $rST->r_date = $pT->date;
	      $rST->r_total_amount = $pT->total_amount;
	      $rST->r_total_paid_amount = $pT->total_paid_amount;
	      $rST->r_total_unpaid_amount = $pT->total_unpaid_amount;
	      $rST->r_payment_complete_status = $pT->payment_complete_status;
	      $rST->r_operation = "editPurchase";
	      $rST->completed = 0;

	      $rST->save();




	      $count1 = $pT->purchaseTransactionItem->count();

	      for( $i = 0; $i < $count1; $i++ )
	      {
	          $rSTI = new RequestedSalesTransactionItem();

	          $rSTI->r_transaction_id = $rST->id;
	          $rSTI->r_items = $pT->purchaseTransactionItem[$i]->items;
	          $rSTI->r_quantity = $pT->purchaseTransactionItem[$i]->quantity;
	          $rSTI->r_unit = $pT->purchaseTransactionItem[$i]->unit;
	          $rSTI->r_rate = $pT->purchaseTransactionItem[$i]->rate;
	          $rSTI->r_total_price = $pT->purchaseTransactionItem[$i]->total_price;

	          $rSTI->save();
	      }




	      $count2 = $request['count'];

	      for( $i = 0; $i < $count2; $i++ )
	      {
	          $rSIP = new RequestedSalesInstallmentPayment();

	          $rSIP->r_transaction_id = $rST->id;
	          $rSIP->r_user_id = Auth::user()->id;
	          $rSIP->r_paid_amount = $request['iPaidAmount'][$i];
	          $rSIP->r_payment_method = $request['iPaymentMethod'][$i];

	          $r_total_paid_amount = $r_total_paid_amount + $request['iPaidAmount'][$i];

	          $rSIP->save();
	      }

	      $uRST = RequestedSalesTransaction::where('id', '=', $rST->id)
	                              ->first();
	      $r_total_amount = $uRST->r_total_amount;
	      $r_total_unpaid_amount = $uRST->r_total_amount - $r_total_paid_amount;

	      $uRST->r_total_paid_amount = $r_total_paid_amount;
	      $uRST->r_total_unpaid_amount = $r_total_unpaid_amount;

	      if( $r_total_amount > $r_total_paid_amount )
	          $r_payment_complete_status = 0;
	      else
	          $r_payment_complete_status = 1;

	      $uRST->update();
	  }
	  catch( \Exception $e )
	  {
	      return redirect()->back()->with('unsuccessMessage', 'Failed to send edit request of payment to admin!!!');
	  }
	  

	  return redirect()->back()->with('successMessage', 'Edit Request of payment has been sent to admin !!!');
  }

  public function ajaxShowShop(Request $request)
  {
  	if( $request->ajax() )
  	{
  		$shopDetail = Shop::with('contactNumbers')
  								->where('id', '=', $request->shopId)
								->first();	

		return Response($shopDetail);
  	}
  }
}

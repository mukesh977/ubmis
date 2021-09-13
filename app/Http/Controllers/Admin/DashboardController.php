<?php

namespace App\Http\Controllers\Admin;

use App\Models\Access\User\User;
use App\Models\FieldVisit\FieldVisit;
use App\Models\Sales\Sales;
use App\Models\Sales\UserSales;
use App\Models\Targets\Target;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Models\Sales\SalesCategory;
use App\Models\SalesTransaction\SalesTransaction;
use App\Models\SalesTransaction\SalesTransactionsItem;
use App\Models\SalesTransaction\SalesInstallmentPayment;
use App\Models\SalesTransaction\SalesTransactionsItemFb;
use App\Models\PurchaseTransaction\PurchaseTransaction;
use App\Models\PurchaseTransaction\PurchaseTransactionItem;
use App\Models\PurchaseTransaction\PurchaseInstallmentPayment;
use App\Models\RequestedTransaction\RequestedSalesTransaction;
use App\Models\RequestedTransaction\RequestedSalesTransactionItem;
use App\Models\RequestedTransaction\RequestedSalesInstallmentPayment;
use App\Models\RequestedTransaction\RequestedSTItemFb;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Package\SeoPackage;
use App\Models\Package\AmcPackage;
use App\Models\Employee\EmployeeDetail;

class DashboardController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

  private $paginationNumber = 24;
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$users = User::count();
    	$fieldVisits = FieldVisit::count();
    	$myVisits = FieldVisit::where('user_id', Auth::user()->id)->count();

    	$targets = Target::all();
	    $salesTargets = array();
	    $sales = array();
	    $first_sales_date = Sales::orderBy('created_at', 'asc')->first();
	    if ($first_sales_date){
		    $weeklyDate = Carbon::parse($first_sales_date->date)->addDays(7)->toDateString();
		    $monthlyDate = Carbon::parse($first_sales_date->date)->addDays(30)->toDateString();
		    $quarterlyDate = Carbon::parse($first_sales_date->date)->addDays(90)->toDateString();
		    
    	    foreach($targets as $count => $target){
    		    $salesTargets[$count]['y'] = UserSales::whereHas('targets', function($query) use($target){
    			    $query->where('target_id', $target->id);
    		    })->sum('total_sales');
    
    		    $salesTargets[$count]['label'] = ucfirst($target->name);
    		    switch ($target->name) {
    			    case 'Daily':
    				    $salesTargets[$count]['total_sales'] = Sales::where('date',Carbon::now()->toDateString())->sum('received_amount');
    				    break;
    			    case 'Weekly':
    				    $salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
    				    break;
    			    case 'Monthly':
    				    $salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
    				    break;
    			    case 'Quarterly':
    				    $salesTargets[$count]['total_sales'] = Sales::whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
    				    break;
    		    }
    	    }
	        foreach($targets as $count => $target){
		    switch ($target->name) {
			    case 'Daily':
				    $sales[$count]['y'] = Sales::where('date',Carbon::now()->toDateString())->sum('received_amount');
				    break;
			    case 'Weekly':
				    $sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $weeklyDate])->sum('received_amount');
				    break;
			    case 'Monthly':
				    $sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $monthlyDate])->sum('received_amount');
				    break;
			    case 'Quarterly':
				    $sales[$count]['y'] = Sales::whereBetween('date',[ $first_sales_date->date, $quarterlyDate])->sum('received_amount');
				    break;
		    }
	    }
    	}
	    $totalSalesTargets = UserSales::sum('total_sales');
	    $totalSales = Sales::sum('received_amount');
//	    dd($salesTargets);


        return view('dashboard.admin-dashboard', compact('users','fieldVisits', 'totalSales', 'myVisits', 'salesTargets', 'sales', 'totalSalesTargets'));
    }


    public function showNotifications()
    {
      $paginationNumber = $this->paginationNumber;

      $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                        ->where('completed', '=', 0)
                                        ->paginate($paginationNumber);

        // dd($notifications);

        return view('notifications.list-notifications')->with('notifications', $notifications)
                                                      ->with('paginationNumber', $paginationNumber);;
    }


    public function showIndividualNotification($id)
    {
      $requestId = $id;

      $rST = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User', 'requestedSTItemFb')
                                      ->where('id', '=', $requestId)->first();

      $sT = SalesTransaction::with('company', 'SalesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')
                              ->where('id', '=', $rST->r_actual_sale_id)
                              ->first();

                              // dd($rST);

      $companies = Company::all();
      $services = SalesCategory::all();
      $paymentMethods = PaymentMethod::all();
      $seoPackages = SeoPackage::all();
      $amcPackages = AmcPackage::all();
    
    return view('notifications.single-notification')->with('rST', $rST)
                                                    ->with('sT', $sT)
                                                    ->with('companies', $companies)
                                                    ->with('paymentMethods', $paymentMethods)
                                                    ->with('seoPackages', $seoPackages)
                                                    ->with('amcPackages', $amcPackages)
                                                    ->with('services', $services);
    }


    public function showIndividualPNotification($id)
    {
      $requestId = $id;

      $paymentMethods = PaymentMethod::all();

      $rPT = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                      ->where('id', '=', $requestId)->first();

      $pT = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment')
                              ->where('id', '=', $rPT->r_actual_purchase_id)
                              ->first();

      // dd($pT);

    return view('notifications.single-purchase-notification')->with('rPT', $rPT)
                                                    ->with('pT', $pT)
                                                    ->with('paymentMethods', $paymentMethods);
                                                    
    }


    public function requestChange($id)
    {
      $requestId = $id;

      
        $rST = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User', 'requestedSTItemFb')
                                        ->where('id', '=', $requestId)->first();


        if( $rST->r_operation == "edit" )
        {
          $sT = SalesTransaction::with('salesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')->where('id', '=', $rST->r_actual_sale_id)->first();
// dd($sT);
          //Salestransaction items stored from requestedSalesTransaction table

          $sT->user_id = $rST->r_user_id;
          $sT->company_id = $rST->r_company_id;
          $sT->referred_by = $rST->r_referred_by;
          $sT->sales_code = $rST->r_sales_code;
          $sT->date = $rST->r_date;
          $sT->total_amount = $rST->r_total_amount;
          $sT->total_paid_amount = $rST->r_total_paid_amount;
          $sT->total_unpaid_amount = $rST->r_total_unpaid_amount;
          $sT->payment_complete_status = $rST->r_payment_complete_status;

          $sTI = SalesTransactionsItem::where('sales_transaction_id', '=', $rST->r_actual_sale_id)->delete();
         
         if( !$sT->salesTransactionsItemFb->isEmpty() )
            $deleteSTIFb = SalesTransactionsItemFb::where('sales_transactions_item_id', '=', $sT->salesTransactionsItemFb[0]->sales_transactions_item_id)->delete();

    // dd($rST->requestedSalesTransactionItem[0]->r_service_id);
          
          $count1 = $rST->requestedSalesTransactionItem->count();

          for( $i = 0; $i < $count1; $i++ )
          {
            $sTI = new SalesTransactionsItem();

            $sTI->sales_transaction_id = $rST->r_actual_sale_id;
            $sTI->service_id = $rST->requestedSalesTransactionItem[$i]->r_service_id;
            $sTI->total_price = $rST->requestedSalesTransactionItem[$i]->r_total_price;
            $sTI->information = $rST->requestedSalesTransactionItem[$i]->r_information;
            $sTI->start_date = $rST->requestedSalesTransactionItem[$i]->r_start_date;
            $sTI->end_date = $rST->requestedSalesTransactionItem[$i]->r_end_date;

            $sTI->save();

            if( $rST->requestedSalesTransactionItem[$i]->r_service_id == 3 )
            {
              $countFbDetail = $rST->requestedSTItemFb->count();

              for( $j = 0; $j < $countFbDetail; $j++ )
              {
                  $fbItems = new SalesTransactionsItemFb();

                  $fbItems->sales_transactions_item_id = $sTI->id;
                  $fbItems->particulars = $rST->requestedSTItemFb[$j]->r_particulars;
                  $fbItems->dollar = $rST->requestedSTItemFb[$j]->r_dollar;
                  $fbItems->graphics = $rST->requestedSTItemFb[$j]->r_graphics;
                  $fbItems->total = $rST->requestedSTItemFb[$j]->r_total;

                  $fbItems->save();

              }
            }
          }


          $sIP = SalesInstallmentPayment::where('sales_transaction_id', '=', $rST->r_actual_sale_id)->delete();

          $count2 = $rST->requestedSalesInstallmentPayment->count();

          for( $i = 0; $i < $count2; $i++ )
          {
            $sIP = new SalesInstallmentPayment();

            $sIP->sales_transaction_id = $rST->r_actual_sale_id;
            $sIP->user_id = $rST->requestedSalesInstallmentPayment[$i]->r_user_id;
            $sIP->paid_amount = $rST->requestedSalesInstallmentPayment[$i]->r_paid_amount;
            $sIP->payment_method = $rST->requestedSalesInstallmentPayment[$i]->r_payment_method;
            $sIP->date = $rST->requestedSalesInstallmentPayment[$i]->r_date;

            $paymentMethods = PaymentMethod::all();

            foreach( $paymentMethods as $paymentMethod )
            {
              if( $paymentMethod->name == "cheque" )
              {
                if( $paymentMethod->id == $rST->requestedSalesInstallmentPayment[$i]->r_payment_method )
                  $sIP->cheque_number = $rST->requestedSalesInstallmentPayment[$i]->r_cheque_number;
              }
            }

            $sIP->save();
          }

          $sT->update();


          //requestedSalesTransaction table items updated

          $rST->completed = 1;

          $rST->update();

          $paginationNumber = $this->paginationNumber;

          $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                          ->where('completed', '=', 0)
                                          ->paginate($paginationNumber);

          //updates updated_expiration_date column in timely_notifications table 
          $timelyNotifications = \App\Models\Notification\TimelyNotification::where('sales_transaction_id', $rST->r_actual_sale_id)->get();

          if( !$timelyNotifications->isEmpty() )
          {
            $rSTICount = $rST->requestedSalesTransactionItem->count();
            foreach( $timelyNotifications as $timelyNotification )
            {
              for( $i = 0; $i < $rSTICount; $i++ )
              {
                if( ($timelyNotification->service_id == $rST->requestedSalesTransactionItem[$i]->r_service_id) && ( $timelyNotification->information == $rST->requestedSalesTransactionItem[$i]->r_information) )
                {
                  $tN = \App\Models\Notification\TimelyNotification::where('id', '=', $timelyNotification->id)->first();

                  $tN->updated_expiration_date = $rST->requestedSalesTransactionItem[$i]->r_end_date;

                  $tN->update();
                }
              }
            }
          }
          
        }
        else if( $rST->r_operation == "delete" )
        {
          $paginationNumber = $this->paginationNumber;

                                          
          $sT = Salestransaction::where('id', '=', $rST->r_actual_sale_id)->delete();

          $rST->completed = 1;

          $rST->update();
          
          $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')->where('completed', '=', 0)
                                          ->paginate($paginationNumber);
        }


      // return view('notifications.list-notifications')
      //                             ->with('notifications', $notifications)
      //                             ->with('paginationNumber', $paginationNumber)
      //                             ->with('successMessage', 'Update changes successfully !!!');

      return redirect('/admin/notifications')
                                  ->with('notifications', $notifications)
                                  ->with('paginationNumber', $paginationNumber)
                                  ->with('successMessage', 'Update changes successfully !!!');
    } 


    public function requestNoChange($id)
    {
      $requestId = $id;

      try
      {
        $rST = RequestedSalesTransaction::where('id', '=', $requestId)->first();

        $rST->completed = 1;

        $rST-> update();

        $paginationNumber = $this->paginationNumber;

        $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                        ->where('completed', '=', 0)
                                        ->paginate($paginationNumber);
        
      }
      catch( \Exception $e )
      {
        return view('notifications.list-notifications')
                                  ->with('notifications', $notifications)
                                  ->with('paginationNumber', $paginationNumber)
                                  ->with('unsuccessMessage', 'Failed to update changes !!!');
      }


      return redirect('/admin/notifications')
                                  ->with('notifications', $notifications)
                                  ->with('paginationNumber', $paginationNumber)
                                  ->with('successMessage', 'Update changes successfully !!!'); 
    }


    public function requestPurchaseChange($id)
    {
      $requestId = $id;

        $rPT = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                        ->where('id', '=', $requestId)->first();
        
        if( $rPT->r_operation == "editPurchase" )
        {
          $pT = PurchaseTransaction::with('purchaseTransactionItem', 'purchaseInstallmentPayment')->where('id', '=', $rPT->r_actual_purchase_id)->first();

          //Salestransaction items stored from requestedSalesTransaction table

          $pT->user_id = $rPT->r_user_id;
          $pT->shop_id = $rPT->r_shop_id;
          $pT->purchase_code = $rPT->r_purchase_code;
          $pT->date = $rPT->r_date;
          $pT->total_amount = $rPT->r_total_amount;
          $pT->total_paid_amount = $rPT->r_total_paid_amount;
          $pT->total_unpaid_amount = $rPT->r_total_unpaid_amount;
          $pT->payment_complete_status = $rPT->r_payment_complete_status;

          $pTI = PurchaseTransactionItem::where('purchase_transaction_id', '=', $rPT->r_actual_purchase_id)->delete();

    // dd($rST->requestedSalesTransactionItem[0]->r_service_id);
          

          $count1 = $rPT->requestedSalesTransactionItem->count();

          for( $i = 0; $i < $count1; $i++ )
          {
            $pTI = new PurchaseTransactionItem();

            $pTI->purchase_transaction_id = $rPT->r_actual_purchase_id;
            $pTI->items = $rPT->requestedSalesTransactionItem[$i]->r_items;
            $pTI->rate = $rPT->requestedSalesTransactionItem[$i]->r_rate;
            $pTI->quantity = $rPT->requestedSalesTransactionItem[$i]->r_quantity;
            $pTI->unit = $rPT->requestedSalesTransactionItem[$i]->r_unit;
            $pTI->total_price = $rPT->requestedSalesTransactionItem[$i]->r_total_price;

            $pTI->save();
          }


          $pIP = PurchaseInstallmentPayment::where('purchase_transaction_id', '=', $rPT->r_actual_purchase_id)->delete();

          $count2 = $rPT->requestedSalesInstallmentPayment->count();

          for( $i = 0; $i < $count2; $i++ )
          {
            $pIP = new PurchaseInstallmentPayment();

            $pIP->purchase_transaction_id = $rPT->r_actual_purchase_id;
            $pIP->user_id = $rPT->requestedSalesInstallmentPayment[$i]->r_user_id;
            $pIP->paid_amount = $rPT->requestedSalesInstallmentPayment[$i]->r_paid_amount;
            $pIP->payment_method = $rPT->requestedSalesInstallmentPayment[$i]->r_payment_method;

            $pIP->save();
          }

          $pT->update();


          //requestedSalesTransaction table items updated

          $rPT->completed = 1;

          $rPT->update();

          $paginationNumber = $this->paginationNumber;

          $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                          ->where('completed', '=', 0)
                                          ->paginate($paginationNumber);
        }
        else if( $rPT->r_operation == "deletePurchase" )
        {
          $paginationNumber = $this->paginationNumber;


          $pT = Purchasetransaction::where('id', '=', $rPT->r_actual_purchase_id)->delete();

          $rPT->completed = 1;

          $rPT->update();

          $notifications = RequestedSalesTransaction::with('requestedSalesTransactionItem', 'requestedSalesInstallmentPayment', 'User')
                                          ->where('completed', '=', 0)
                                          ->paginate($paginationNumber);
        }

      return redirect('/admin/notifications')
                                  ->with('notifications', $notifications)
                                  ->with('paginationNumber', $paginationNumber)
                                  ->with('successMessage', 'Update changes successfully !!!');
    }

    public function notificationCalendar()
    {
      $employees = EmployeeDetail::where('date_of_birth', '!=', NULL)->get();
      $clientFollowUp = \App\Models\Calendar\ClientFollowUpByAdmin::with('company')->get();
      // dd($clientFollowUp);

      return view('adminCalendar.admin-calendar')->with('employees', $employees)
                                            ->with('clientFollowUp', $clientFollowUp);
    }
    
}

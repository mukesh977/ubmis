<?php

namespace App\Http\Controllers\SalesTransaction;

use App\Models\Access\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company\Company;
use App\Models\Sales\SalesCategory;
use App\Models\SalesTransaction\SalesTransaction;
use App\Models\SalesTransaction\SalesTransactionsItem;
use App\Models\SalesTransaction\SalesInstallmentPayment;
use App\Models\SalesTransaction\SalesTransactionsItemFb;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\RequestedTransaction\RequestedSalesTransaction;
use App\Models\RequestedTransaction\RequestedSalesTransactionItem;
use App\Models\RequestedTransaction\RequestedSalesInstallmentPayment;
use App\Models\RequestedTransaction\RequestedSTItemFb;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Email\Email;
use App\Models\Access\Role\Role;
use App\Models\Package\SeoPackage;
use App\Models\Package\AmcPackage;
use DateTime;
use App\Models\Notification\TimelyNotification;
use \App\Models\FieldVisit\FieldVisit;


class SalesTransactionController extends Controller
{
    public function __construct()
    {
    	// $this->middleware('auth');
    	$this->middleware('role:accountant|admin');
    }

    private $paginationNumber = 24;

    public function commands()
     {
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan config:cache'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan config:clear'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan route:clear'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan route:cache'));
            
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan view:clear'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan view:cache'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan optimize'));
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php composer.phar'));
        //dd(shell_exec('cd /home/ultrabyteit/composer && wget https://getcomposer.org/installer'));
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && COMPOSER_HOME="mytempdir/" php composer.phar install --optimize-autoloader --no-dev'));
        
        //dd(shell_exec('cd /home/ultrabyteit/ubmis.ultrabyteit.com && php artisan migrate'));
     }
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create( $id = "" )
    {
        // dd(shell_exec('cd /d e:\xampp\htdocs\ubmis && composer dump-autoload'));
        // dd(shell_exec('php E:\xampp\htdocs\ubmis\artisan make:controller TestController'));
        //dd(shell_exec('cd /d e:\xampp\htdocs\ubmis && php composer.phar dump-autoload'));

    	$companies = Company::all();
    	$services = SalesCategory::all();
        $paymentMethods = PaymentMethod::all();
        $seoPackages = SeoPackage::all();
        $amcPackages = AmcPackage::all();

        $marketingStaffs = User::join('role_user', 'users.id', 'role_user.user_id')
                                ->join('roles', 'role_user.role_id', 'roles.id')
                                ->whereIn('roles.name', ['marketingManager', 'marketingOfficer', 'marketingBoy', 'supporter'])
                                ->select('users.*')
                                ->get();

        
        if( $id == "" )
        {
        	try
        	{
    	    	$lstSalesId = SalesTransaction::orderBy('id', 'DESC')->first()->id;
        	}
        	catch( \Exception $e ){ }

        	if( empty($lstSalesId) )
        		$lastSalesId = 1;
        	else
        		$lastSalesId = $lstSalesId + 1;

        	return view('salesTransaction.add-sales')->with('companies', $companies)
        												->with('services', $services)
                                                        ->with('paymentMethods', $paymentMethods)
        												->with('lastSalesId', $lastSalesId)
                                                        ->with('seoPackages', $seoPackages)
                                                        ->with('amcPackages', $amcPackages)
                                                        ->with('marketingStaffs', $marketingStaffs);
            
        }
        else
        {
            $editSale = SalesTransaction::with('salesTransactionsItem', 'salesInstallmentPayment', 'salesTransactionsItemFb')
                                            ->where('id', '=', $id)
                                            ->first();

                                        // dd($editSale);
            $lastSalesId = 1;

            return view('salesTransaction.add-sales')->with('companies', $companies)
                                                        ->with('services', $services)
                                                        ->with('paymentMethods', $paymentMethods)
                                                        ->with('lastSalesId', $lastSalesId)
                                                        ->with('seoPackages', $seoPackages)
                                                        ->with('amcPackages', $amcPackages)
                                                        ->with('editSale', $editSale)
                                                        ->with('marketingStaffs', $marketingStaffs);

        }

    }

    public function setTimelyNotification( array $data, $successfullySent )
    {
        $timelyNotification = new TimelyNotification();

        $timelyNotification->sales_transaction_item_id = $data['salesTransactionItemId'];
        $timelyNotification->company_id = $data['companyId'];
        $timelyNotification->service_id = $data['serviceId'];
        $timelyNotification->information = $data['information'];
        $timelyNotification->remaining_days = $data['remainingDays'];
        $timelyNotification->successfully_sent = $successfullySent;

        $timelyNotification->seen = 0;

        $timelyNotification->save();
    }

    public function getSeoAmcInformation(Request $request)
    {
        if( $request->ajax() )
        {
            $seoPackage = SeoPackage::all();
            $amcPackage = AmcPackage::all();

            return response()->json([$seoPackage, $amcPackage]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	        'salesCode' => 'required|string',
	        'date' => 'required|string',
	        'officeName' => 'required|numeric|exists:companies,id',
            'referredBy' => 'required|numeric|exists:users,id',

	        'service.*' => 'required|numeric|exists:sales_categories,id',
	        'price.*' => 'required|numeric',
            'information.*' => 'nullable|string',
            'startDate.*' => 'nullable|date',
            'endDate.*' => 'nullable|date',
	        'paidAmount' => 'nullable|numeric',
	        'unpaidAmount' => 'required|numeric',
            'paymentMethod' => 'nullable|numeric|exists:payment_methods,id',
           
            'particulars.*' => 'nullable|string',
            'dollar.*' => 'nullable|numeric',
            'graphics.*' => 'nullable|numeric',
	        'total.*' => 'nullable|numeric',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        $totalData = $request['count'] + 1;

        if( $request['saleId'] == "" )
        {
            try
            {
                $salesTransaction = new salesTransaction();

                $salesTransaction->sales_code = $request['salesCode'];
                $salesTransaction->date = $request['date'];
                $salesTransaction->company_id = $request['officeName'];
                $salesTransaction->referred_by = $request['referredBy'];
                $salesTransaction->user_id = Auth::user()->id;
                $salesTransaction->total_amount = $request['totalAmount'];
                $salesTransaction->total_unpaid_amount = $request['unpaidAmount'];

                if( empty($request['paidAmount']) )
                    $salesTransaction->total_paid_amount = 0;
                else
                    $salesTransaction->total_paid_amount = $request['paidAmount'];


                if( $request['totalAmount'] == $request['paidAmount'])
                    $salesTransaction->payment_complete_status = 1;
                else
                    $salesTransaction->payment_complete_status = 0;


                $salesTransaction->save();


                for( $i = 0; $i < $totalData; $i++ )
                {
                    $salesTransactionsItem = new SalesTransactionsItem();

                    $salesTransactionsItem->sales_transaction_id = $salesTransaction->id;
                    $salesTransactionsItem->service_id = $request['service'][$i];
                    $salesTransactionsItem->total_price = $request['price'][$i];

                    if( !empty($request['information'][$i]) )
                        $salesTransactionsItem->information = $request['information'][$i];

                    if( !empty($request['startDate'][$i]) )
                        $salesTransactionsItem->start_date = $request['startDate'][$i];

                    if( !empty($request['endDate'][$i]) )
                        $salesTransactionsItem->end_date = $request['endDate'][$i];

                    $salesTransactionsItem->save();

                    if( $request['service'][$i] == 3 )
                    {
                        $countFbDetail = count($request['particulars']);

                        for( $j = 0; $j < $countFbDetail; $j++ )
                        {
                            $fbItems = new SalesTransactionsItemFb();

                            $fbItems->sales_transactions_item_id = $salesTransactionsItem->id;
                            $fbItems->particulars = $request['particulars'][$j];
                            $fbItems->dollar = $request['dollar'][$j];
                            $fbItems->graphics = $request['graphics'][$j];
                            $fbItems->total = $request['total'][$j];

                            $fbItems->save();

                        }
                    }
                }

                if( $request['paidAmount'] > 0 )
                {
                    $salesInstallmentPayment = new SalesInstallmentPayment();

                    $salesInstallmentPayment->sales_transaction_id = $salesTransaction->id;
                    $salesInstallmentPayment->user_id = Auth::user()->id;
                    $salesInstallmentPayment->paid_amount = $request['paidAmount'];
                    $salesInstallmentPayment->payment_method = $request['paymentMethod'];
                    $salesInstallmentPayment->date = date("Y-m-d");

                    $paymentMethods = PaymentMethod::all();

                    foreach( $paymentMethods as $paymentMethod )
                    {
                        if( $paymentMethod->name = "cheque" )
                        {
                            if( $paymentMethod->id == $request['paymentMethod'])
                                $salesInstallmentPayment->cheque_number = $request['chequeNumber'];
                        }

                    }

                    $salesInstallmentPayment->save();

                }

            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to add new sales transaction !!!');
            }

            try
            {
                $email = Email::where('company_id', '=', $request['officeName'])
                                    ->where('type', '=', 'primary')
                                    ->first()
                                    ->email;

                $companyName = Company::where('id', '=', $request['officeName'])->first()->name;

                $name = explode(' ', $companyName, 2);
                $password = $this->getRandomWord(16);
                $clientRoleId = Role::where('name', '=', 'client')->first()->id;


                $user = User::where('company_id', '=', $request['officeName'])->first();

                if( $user == NULL )
                {
                    $data = array(
                        'subject' => 'Ultrabyte Account Section',
                        'username' => $email,
                        'password' => $password,
                        'view' => 'mail.mail',
                    );

                    // dd($email);
                    // Mail::to($email)->from('account@ultrabyteit.com')->subject($this->data['subject'])->view($this->data['view'])->with('data', $this->data);
                    Mail::to($email)->send(new sendMail($data));
                    
                    $user = new User();

                    $user->company_id = $request['officeName'];
                    $user->first_name = $name[0];
                        
                    if(!empty($name[1]))
                        $user->last_name = $name[1];

                    $user->email = $email;
                    $user->password = bcrypt($password);

                    $user->save();
                    $user->roles()->attach($clientRoleId);
                }

                
            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to send account login information email to our client !!!');
            } 


            return redirect()->back()->with('successMessage', 'New sales added successfully!!!');
        }
        else
        {
            
        }
        
    }

    public function update($id='', Request $request)
    {
        $validator = Validator::make($request->all(), [
            'salesCode' => 'required|string',
            'date' => 'required|string',
            'officeName' => 'required|numeric|exists:companies,id',
            'referredBy' => 'required|numeric|exists:users,id',

            'service.*' => 'required|numeric|exists:sales_categories,id',
            'price.*' => 'required|numeric',
            'information.*' => 'nullable|string',
            'startDate.*' => 'nullable|date',
            'endDate.*' => 'nullable|date',
            'paidAmount' => 'nullable|numeric',
            'paymentMethod' => 'nullable|numeric|exists:payment_methods,id',
           
            'particulars.*' => 'nullable|string',
            'dollar.*' => 'nullable|numeric',
            'graphics.*' => 'nullable|numeric',
            'total.*' => 'nullable|numeric',
            ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        $totalData = $request['count'] + 1;

        if( $request['saleId'] == "" )
        {
            
        }
        else
        {
            $totalData = $totalData - 1;
            $sT = SalesTransaction::where('id', '=', $request['saleId'])->first();
            
            try
            {
                $rSalesTransaction = new RequestedSalesTransaction();

                $rSalesTransaction->r_actual_sale_id = $request['saleId'];
                $rSalesTransaction->r_sales_code = $request['salesCode'];
                $rSalesTransaction->r_date = $request['date'];
                $rSalesTransaction->r_company_id = $request['officeName'];
                $rSalesTransaction->r_referred_by = $request['referredBy'];
                $rSalesTransaction->r_user_id = Auth::user()->id;
                $rSalesTransaction->r_total_amount = $request['totalAmount'];

                $paidAmount = $sT->total_paid_amount;
                $unpaidAmount = $request['totalAmount'] - $paidAmount;

                $rSalesTransaction->r_total_paid_amount = $paidAmount;
                $rSalesTransaction->r_total_unpaid_amount = $unpaidAmount;
                $rSalesTransaction->r_operation = "edit";
                $rSalesTransaction->completed = 0;

                if( $request['totalAmount'] > $paidAmount)
                    $rSalesTransaction->r_payment_complete_status = 0;
                else
                    $rSalesTransaction->r_payment_complete_status = 1;


                $rSalesTransaction->save();


                for( $i = 0; $i < $totalData; $i++ )
                {
                    $rSalesTransactionsItem = new RequestedSalesTransactionItem();

                    $rSalesTransactionsItem->r_transaction_id = $rSalesTransaction->id;
                    $rSalesTransactionsItem->r_service_id = $request['service'][$i];
                    $rSalesTransactionsItem->r_total_price = $request['price'][$i];

                    if( !empty($request['information'][$i]) )
                        $rSalesTransactionsItem->r_information = $request['information'][$i];

                    if( !empty($request['startDate'][$i]) )
                        $rSalesTransactionsItem->r_start_date = $request['startDate'][$i];
                    
                    if( !empty($request['endDate'][$i]) )
                        $rSalesTransactionsItem->r_end_date = $request['endDate'][$i];

                    $rSalesTransactionsItem->save();

                    if( $request['service'][$i] == 3 )
                    {
                        $countFbDetail = count($request['particulars']);

                        for( $j = 0; $j < $countFbDetail; $j++ )
                        {
                            $fbItems = new RequestedSTItemFb();

                            $fbItems->r_s_t_item_id = $rSalesTransactionsItem->id;
                            $fbItems->r_particulars = $request['particulars'][$j];
                            $fbItems->r_dollar = $request['dollar'][$j];
                            $fbItems->r_graphics = $request['graphics'][$j];
                            $fbItems->r_total = $request['total'][$j];

                            $fbItems->save();

                        }
                    }
                }

                $sIP = SalesInstallmentPayment::where('sales_transaction_id', '=', $request['saleId'])->get();
                $totalPaidAmount = 0;

                if( !$sIP->isEmpty() )
                {
                    $totald = $sIP->count();

                    for( $i = 0; $i < $totald; $i++ )
                    {
                        $rSalesInstallmentPayment = new RequestedSalesInstallmentPayment();

                        $rSalesInstallmentPayment->r_transaction_id = $rSalesTransaction->id;
                        $rSalesInstallmentPayment->r_user_id = Auth::user()->id;
                        $rSalesInstallmentPayment->r_paid_amount = $sIP[$i]->paid_amount;
                        $rSalesInstallmentPayment->r_payment_method = $sIP[$i]->payment_method;
                        $rSalesInstallmentPayment->r_cheque_number = $sIP[$i]->cheque_number;
                        $rSalesInstallmentPayment->r_date = $sIP[$i]->date;
                        $totalPaidAmount += $sIP[$i]->paid_amount;

                        $rSalesInstallmentPayment->save();
                    }
                    
                    $rST = RequestedSalesTransaction::where('id', '=', $rSalesTransaction->id)->first();
                    
                    $totalUnpaidAmount = $rST->r_total_amount - $totalPaidAmount;
                    $rST->r_total_paid_amount = $totalPaidAmount;
                    $rST->r_total_unpaid_amount = $totalUnpaidAmount;

                    if( $rST->r_total_amount > $totalPaidAmount )
                        $rST->r_payment_complete_status = 0;
                    else
                        $rST->r_payment_complete_status = 1;

                    $rST->update();
                }
            }
            catch( \Exception $e )
            {
                return redirect('/add-sales')->with('unsuccessMessage', 'Failed to send data to administrator for editing sales transaction !!!');
            }
            

            return redirect('/add-sales')->with('successMessage', 'Data has been sent to administrator for editing sales transaction !!!');
        }
    }


    public function getRandomWord($len = 10) 
    {
        $word = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    public function show()
    {
        $paginationNumber = 24;

        $salesTransactions = SalesTransaction::with('company')
                                                ->orderBy('payment_complete_status', 'ASC')
                                                ->orderBy('date', 'DESC')
                                                ->paginate($paginationNumber);

        return view('salesTransaction.list-sales')->with('salesTransactions', $salesTransactions)
                                                    ->with('paginationNumber', $paginationNumber);
    
    }


    public function destroy(Request $request)
    {
        $salesId = $request['sales_id_delete'];

        $deleteSale = SalesTransaction::with('SalesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')->where('id','=', $salesId)->first();

        try 
        {
            $requestedSales = new RequestedSalesTransaction();

            $requestedSales->r_actual_sale_id = $deleteSale->id;
            $requestedSales->r_sales_code = $deleteSale->sales_code;
            $requestedSales->r_date = $deleteSale->date;
            $requestedSales->r_company_id = $deleteSale->company_id;
            $requestedSales->r_user_id = Auth::user()->id;
            $requestedSales->r_total_amount = $deleteSale->total_amount;
            $requestedSales->r_total_paid_amount = $deleteSale->total_paid_amount;
            $requestedSales->r_total_unpaid_amount = $deleteSale->total_unpaid_amount;
            $requestedSales->r_payment_complete_status = $deleteSale->payment_complete_status;
            $requestedSales->r_operation = "delete";
            $requestedSales->completed = 0;

            $requestedSales->save();


            $totalData = $deleteSale->salesTransactionsItem->count();

            for( $i = 0; $i < $totalData; $i++ )
            {
                $rSalesTransactionsItem = new RequestedSalesTransactionItem();

                $rSalesTransactionsItem->r_transaction_id = $requestedSales->id;
                $rSalesTransactionsItem->r_service_id = $deleteSale->salesTransactionsItem[$i]->service_id;
                $rSalesTransactionsItem->r_total_price = $deleteSale->salesTransactionsItem[$i]->total_price;
                $rSalesTransactionsItem->r_information = $deleteSale->salesTransactionsItem[$i]->information;

                $rSalesTransactionsItem->save();

                if( $deleteSale->salesTransactionsItem[$i]->service_id == 3 )
                {
                  $countFbDetail = $deleteSale->salesTransactionsItemFb->count();

                  for( $j = 0; $j < $countFbDetail; $j++ )
                  {
                      $fbItems = new RequestedSTItemFb();

                      $fbItems->r_s_t_item_id = $rSalesTransactionsItem->id;
                      $fbItems->r_particulars = $deleteSale->salesTransactionsItemFb[$j]->particulars;
                      $fbItems->r_dollar = $deleteSale->salesTransactionsItemFb[$j]->dollar;
                      $fbItems->r_graphics = $deleteSale->salesTransactionsItemFb[$j]->graphics;
                      $fbItems->r_total = $deleteSale->salesTransactionsItemFb[$j]->total;

                      $fbItems->save();

                  }
                }
            }

            $totald = $deleteSale->salesInstallmentPayment->count();

            for( $i = 0; $i < $totald; $i++ )
            {
                $rSalesInstallmentPayment = new RequestedSalesInstallmentPayment();

                $rSalesInstallmentPayment->r_transaction_id = $requestedSales->id;
                $rSalesInstallmentPayment->r_user_id = $deleteSale->salesInstallmentPayment[$i]->user_id;
                $rSalesInstallmentPayment->r_paid_amount = $deleteSale->salesInstallmentPayment[$i]->paid_amount;
                $rSalesInstallmentPayment->r_payment_method = $deleteSale->salesInstallmentPayment[$i]->payment_method;
                $rSalesInstallmentPayment->r_cheque_number = $deleteSale->salesInstallmentPayment[$i]->cheque_number;
                $rSalesInstallmentPayment->r_date = $deleteSale->salesInstallmentPayment[$i]->date;

                $rSalesInstallmentPayment->save();
            }
        }
        catch( \Exception $e )
        {
            return redirect()->back()->with('unsuccessMessage', 'Failed to send data to administrator for deleting sales transaction !!!');

        }            
            
        return redirect()->back()->with('successMessage', 'Data has been sent to administrator for deleting sales transaction !!!');
    }


    public function ajaxShow(Request $request)
    {
        if( $request->ajax() )
        {
            $sales = SalesTransaction::with('company', 'SalesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')->where('id','=', $request->id)->first();
            
            $services = SalesCategory::all();

            $serviceName = SalesTransactionsItem::with('salesCategory')->where('sales_transaction_id', '=', $request->id)->get();

            return Response([$sales, $services, $serviceName]);
        }
    }

    public function salesPay( $id )
    {
        $companies = Company::all();
        $services = SalesCategory::all();
        $paymentMethods = PaymentMethod::all();
        $seoPackages = SeoPackage::all();
        $amcPackages = AmcPackage::all();

        $sale = SalesTransaction::with('salesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')
                                            ->where('id', '=', $id)
                                            ->first();
        // dd($sale);


        return view('salesTransaction.sales-pay')->with('companies', $companies)
                                                    ->with('services', $services)
                                                    ->with('paymentMethods', $paymentMethods)
                                                    ->with('seoPackages', $seoPackages)
                                                    ->with('amcPackages', $amcPackages)
                                                    ->with('sale', $sale);

    }


    public function payProcessing(Request $request)
    {


        $payingAmount = $request['payAmount'];
        $saleId = $request['saleId'];
        $paymentMethod = $request['pMethod'];
        $chequeNumber = $request['chequeNumber'];
        $paymentMethods = PaymentMethod::all();

        try
        {
            $salesInstallmentPayment = new SalesInstallmentPayment();

            $salesInstallmentPayment->sales_transaction_id = $saleId;
            $salesInstallmentPayment->user_id = Auth::user()->id;
            $salesInstallmentPayment->paid_amount = $payingAmount;
            $salesInstallmentPayment->payment_method = $paymentMethod;
            $salesInstallmentPayment->date = date("Y-m-d");

            foreach( $paymentMethods as $pM )
            {
                if( $pM->name == "cheque" )
                {
                    if( $pM->id == $paymentMethod )
                        $salesInstallmentPayment->cheque_number = $chequeNumber;
                }
            }

            $salesInstallmentPayment->save();

            $total_paid_amount = SalesInstallmentPayment::where('sales_transaction_id', '=', $saleId)->sum('paid_amount');

            $st = SalesTransaction::where('id', '=', $saleId)->first();

            $total_amount = $st->total_amount;

            $st->total_paid_amount = $total_paid_amount;
            $st->total_unpaid_amount = $total_amount - $total_paid_amount;

            if( $total_amount > $total_paid_amount )
                $st->payment_complete_status = 0;
            else
                $st->payment_complete_status = 1;

            $st->update();
        }
        catch( \Exception $e )
        {
            return redirect()->back()->with('unsuccessMessage', 'Failed to update payment !!!');
        }
        
        return redirect()->back()->with('successMessage', 'Payment has been made successfully !!!');
    }


    public function editPayForm( $id )
    {
        $companies = Company::all();
        $services = SalesCategory::all();
        $paymentMethods =PaymentMethod::all();
        $seoPackages = SeoPackage::all();
        $amcPackages = AmcPackage::all();
        $sale = SalesTransaction::with('salesTransactionsItem', 'SalesInstallmentPayment')
                                            ->where('id', '=', $id)
                                            ->first();

        $editSale = 1;

        return view('salesTransaction.sales-pay')->with('companies', $companies)
                                                ->with('services', $services)
                                                ->with('sale', $sale)
                                                ->with('seoPackages', $seoPackages)
                                                ->with('amcPackages', $amcPackages)
                                                ->with('paymentMethods', $paymentMethods)
                                                ->with('editSale', $editSale);
    }


    public function editPay(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [

            'iPaidAmount.*' => 'required|numeric',
            'iPaymentMethod.*' => 'required',
            'iChequeNumber.*' => 'nullable|numeric',
            'date.*' => 'required|date',
            ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }   


        $saleId = $request['saleId'];

        try
        {
            $sT = SalesTransaction::with('salesTransactionsItem', 'SalesInstallmentPayment', 'salesTransactionsItemFb')
                                    ->where('id', '=', $saleId)
                                    ->first();

            $r_total_paid_amount = 0;

            $rST = new RequestedSalesTransaction();

            $rST->r_actual_sale_id = $saleId;
            $rST->r_user_id = Auth::user()->id;
            $rST->r_company_id = $sT->company_id;
            $rST->r_referred_by = $sT->referred_by;
            $rST->r_sales_code = $sT->sales_code;
            $rST->r_date = $sT->date;
            $rST->r_total_amount = $sT->total_amount;
            $rST->r_total_paid_amount = $sT->total_paid_amount;
            $rST->r_total_unpaid_amount = $sT->total_unpaid_amount;
            $rST->r_payment_complete_status = $sT->payment_complete_status;
            $rST->r_operation = "edit";
            $rST->completed = 0;

            $rST->save();




            $count1 = $sT->salesTransactionsItem->count();

            for( $i = 0; $i < $count1; $i++ )
            {
                $rSTI = new RequestedSalesTransactionItem();

                $rSTI->r_transaction_id = $rST->id;
                $rSTI->r_service_id = $sT->salesTransactionsItem[$i]->service_id;
                $rSTI->r_total_price = $sT->salesTransactionsItem[$i]->total_price;
                $rSTI->r_information = $sT->salesTransactionsItem[$i]->information;

                $rSTI->save();

                if( $sT->salesTransactionsItem[$i]->service_id == 3 )
                {
                    $countFbDetail = $sT->salesTransactionsItemFb->count();

                    for( $j = 0; $j < $countFbDetail; $j++ )
                    {
                        $fbItems = new RequestedSTItemFb();

                        $fbItems->r_s_t_item_id = $rSTI->id;
                        $fbItems->r_particulars = $sT->salesTransactionsItemFb[$j]->particulars;
                        $fbItems->r_dollar = $sT->salesTransactionsItemFb[$j]->dollar;
                        $fbItems->r_graphics = $sT->salesTransactionsItemFb[$j]->graphics;
                        $fbItems->r_total = $sT->salesTransactionsItemFb[$j]->total;

                        $fbItems->save();

                    }
                }
            }




            $count2 = $request['count'];

            for( $i = 0; $i < $count2; $i++ )
            {
                $rSIP = new RequestedSalesInstallmentPayment();

                $rSIP->r_transaction_id = $rST->id;
                $rSIP->r_user_id = Auth::user()->id;
                $rSIP->r_paid_amount = $request['iPaidAmount'][$i];
                $rSIP->r_payment_method = $request['iPaymentMethod'][$i];
                $rSIP->r_date = $request['date'][$i];

                $paymentMethods = PaymentMethod::all();

                foreach( $paymentMethods as $paymentMethod )
                {
                    if( $paymentMethod->name == "cheque" )
                    {
                        if( $paymentMethod->id == $request['iPaymentMethod'][$i] )
                            $rSIP->r_cheque_number = $request['iChequeNumber'][$i];

                    }
                }

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
                $uRST->r_payment_complete_status = 0;
            else
                $uRST->r_payment_complete_status = 1;

            $uRST->update();
            // dd($uRST);
        }
        catch( \Exception $e )
        {
            return redirect()->back()->with('unsuccessMessage', 'Failed to send edit request of payment to admin!!!');
        }
        

        return redirect()->back()->with('successMessage', 'Edit Request of payment has been sent to admin !!!');
    }


    public function ajaxShowCompany(Request $request)
    {
        if( $request->ajax() )
        {
            $companyDetail = Company::with('contactNumbers', 'emails')
                                        ->where('id', '=', $request->companyId)
                                        ->first();

            return Response($companyDetail);
        }
    }

    public function companyWithFieldVisitContact(Request $request)
    {
        if( $request->ajax() )
        {
            $companyDetail = Company::with('contactNumbers', 'emails')
                                        ->where('id', '=', $request->companyId)
                                        ->first();

            $fieldVisitContacts = FieldVisit::with('contactDetails')
                                            ->where('company_id', '=', $request['companyId'])
                                            ->orderBy('created_at', 'DESC')
                                            ->select('field_visits.id')
                                            ->get();

                                            // dd($fieldVisitContacts);

            return Response([$companyDetail, $fieldVisitContacts]);
        }
    }


    public function getDueTransactions(Request $request)
    {
        $dueTransactions = SalesTransaction::with('company')->get();
        $paymentMethods = PaymentMethod::all();

        $countDueTransactions = $dueTransactions->count();

        $officeIdArray = array();
        $tempOfficeDetailArray = array();
        $tempTotalAmount = array();
        $tempTotalPaidAmount = array();
        $tempTotalUnpaidAmount = array();
        $oDA = array();


        for( $i = 0; $i < $countDueTransactions; $i++ )
        {
            if( !in_array( $dueTransactions[$i]->company_id, $officeIdArray ) )
            {
                $officeIdArray[] =  $dueTransactions[$i]->company_id;
                $tempOfficeDetailArray[] = $dueTransactions[$i];
                $oDA[] = $dueTransactions[$i]->toArray();

                $tempTotalAmount[] += $dueTransactions[$i]->total_amount;
                $tempTotalPaidAmount[] += $dueTransactions[$i]->total_paid_amount;
                $tempTotalUnpaidAmount[] += $dueTransactions[$i]->total_unpaid_amount;
            }
            else
            {
                for( $j = 0; $j < count($officeIdArray); $j++ )
                {
                    if( $officeIdArray[$j] == $dueTransactions[$i]->company_id )
                    {
                        $tempTotalAmount[$j] += $dueTransactions[$i]->total_amount; 
                        $tempTotalPaidAmount[$j] += $dueTransactions[$i]->total_paid_amount; 
                        $tempTotalUnpaidAmount[$j] += $dueTransactions[$i]->total_unpaid_amount; 
                        break;
                    }
                }
            }

        }


        // $sortedArray = $this->array_sort($oDA, "total_unpaid_amount", SORT_DESC);
        $sortedArray = array_multisort( $tempTotalUnpaidAmount, SORT_DESC, $tempTotalAmount, SORT_DESC, $tempTotalPaidAmount, $tempOfficeDetailArray );


        $result = array();

        for( $i = 0; $i < count($tempTotalAmount); $i++ )
        {
            if( $tempTotalUnpaidAmount[$i] > 0 )
            {
                $result[] = array(
                                'officeDetailArray' => $tempOfficeDetailArray[$i],
                                'totalAmount' => $tempTotalAmount[$i],
                                'totalPaidAmount' => $tempTotalPaidAmount[$i],
                                'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
                            );
            }
        }

        
        // $officeDetailArray = array();
        // $totalAmount = array();
        // $totalPaidAmount = array();
        // $totalUnpaidAmount = array();
        // $result = array();

        // foreach( $sortedArray as $k => $v )
        // {
        //         for( $i = 0; $i < count($tempOfficeDetailArray); $i++ )
        //         {
        //             if( $sortedArray[$k]['company_id'] == $tempOfficeDetailArray[$i]->company_id )
        //             {
        //                 if( $tempTotalUnpaidAmount[$i] > 0 )
        //                 {
        //                     $result[] = array(
        //                                     'officeDetailArray' => $tempOfficeDetailArray[$i],
        //                                     'totalAmount' => $tempTotalAmount[$i],
        //                                     'totalPaidAmount' => $tempTotalPaidAmount[$i],
        //                                     'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
        //                                 );
        //                 }
        //             }
                    
        //         }
                
        // }

       $results = $this->paginator( $result, $request->page, "due-transactions" );


        return view('salesTransaction.due-transactions')
                                        ->with('results', $results)
                                        ->with('paymentMethods', $paymentMethods)
                                        ->with('paginationNumber', $this->paginationNumber);
    }


    public function paginator( $array, $page, $url )
    {
        $page = !empty($page) ? $page : 1; // Get the page=1 from the url
        $perPage = $this->paginationNumber; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $result =  new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => url($url)]
             
        );

        return $result;
    }


    public function getClientTransactions(Request $request)
    {
        $clientTransactions = SalesTransaction::with('company')->get();

        $countClientTransactions = $clientTransactions->count();

        $officeIdArray = array();
        $tempOfficeDetailArray = array();
        $tempTotalAmount = array();
        $tempTotalPaidAmount = array();
        $tempTotalUnpaidAmount = array();
        $oDA = array();


        for( $i = 0; $i < $countClientTransactions; $i++ )
        {
            if( !in_array( $clientTransactions[$i]->company_id, $officeIdArray ) )
            {
                $officeIdArray[] =  $clientTransactions[$i]->company_id;
                $tempOfficeDetailArray[] = $clientTransactions[$i];
                $oDA[] = $clientTransactions[$i]->toArray();

                $tempTotalAmount[] += $clientTransactions[$i]->total_amount;
                $tempTotalPaidAmount[] += $clientTransactions[$i]->total_paid_amount;
                $tempTotalUnpaidAmount[] += $clientTransactions[$i]->total_unpaid_amount;
            }
            else
            {
                for( $j = 0; $j < count($officeIdArray); $j++ )
                {
                    if( $officeIdArray[$j] == $clientTransactions[$i]->company_id )
                    {
                        $tempTotalAmount[$j] += $clientTransactions[$i]->total_amount; 
                        $tempTotalPaidAmount[$j] += $clientTransactions[$i]->total_paid_amount; 
                        $tempTotalUnpaidAmount[$j] += $clientTransactions[$i]->total_unpaid_amount; 
                        break;
                    }
                }
            }

        }

        // $sortedArray = $this->array_sort($oDA, "total_amount", SORT_DESC);
        array_multisort($tempTotalAmount, SORT_DESC, $tempTotalUnpaidAmount, SORT_DESC, $tempOfficeDetailArray, $tempTotalPaidAmount);

        $result = array();

        for( $i = 0; $i < count($tempOfficeDetailArray); $i++ )
        {
            $result[] = array(
                            'officeDetailArray' => $tempOfficeDetailArray[$i],
                            'totalAmount' => $tempTotalAmount[$i],
                            'totalPaidAmount' => $tempTotalPaidAmount[$i],
                            'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
                        );
        }

        
        // $officeDetailArray = array();
        // $totalAmount = array();
        // $totalPaidAmount = array();
        // $totalUnpaidAmount = array();
        // $result = array();

        // foreach( $sortedArray as $k => $v )
        // {
        //     for( $i = 0; $i < count($tempOfficeDetailArray); $i++ )
        //     {
        //         if( $sortedArray[$k]['company_id'] == $tempOfficeDetailArray[$i]->company_id )
        //         {
        //             $result[] = array(
        //                             'officeDetailArray' => $tempOfficeDetailArray[$i],
        //                             'totalAmount' => $tempTotalAmount[$i],
        //                             'totalPaidAmount' => $tempTotalPaidAmount[$i],
        //                             'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
        //                         );
        //         }
                
        //     }
        // }

       $results = $this->paginator( $result, $request->page, "client-transactions" );


        return view('salesTransaction.client-transactions')
                                        ->with('results', $results)
                                        ->with('paginationNumber', $this->paginationNumber);

    }


    public function getSpecificClientTransaction($id = '')
    {
        $companyId = $id;

        $salesTransactions = SalesTransaction::where('company_id', '=', $companyId)
                                                ->orderBy('payment_complete_status', 'ASC')
                                                ->orderBy('date', 'DESC')
                                                ->paginate(24);

        foreach( $salesTransactions as $sT )
        {
            if( $sT->payment_complete_status == 0 )
            {
                $paymentComplete = false;
                break;
            }
            else
                $paymentComplete = true;

        }

        $companyName = Company::where('id', '=', $companyId)->first();
        $paymentMethods = PaymentMethod::all();

        return view('salesTransaction.list-company-sales')
                                ->with('salesTransactions', $salesTransactions)
                                ->with('companyName', $companyName)
                                ->with('paymentMethods', $paymentMethods)
                                ->with('paymentComplete', $paymentComplete);

        
    }


    public function array_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            $i = 0;

            foreach ($sortable_array as $k => $v) {
                $new_array[$i] = $array[$k];

                $i++;
            }
        }

        return $new_array;
    }


    public function payDueTransaction(Request $request)
    {
        $companyId = $request['companyId'];
        $paidAmount = $request['payAmount'];
        $paymentMethod = $request['pMethod'];
        $chequeNumber = $request['chequeNumber'];
        $paymentMethods = PaymentMethod::all();

        $salesTransactions = SalesTransaction::with('salesInstallmentPayment')
                                                ->where('company_id', '=', $companyId)
                                                ->where('payment_complete_status', '=', 0)
                                                ->get();
        
        foreach( $salesTransactions as $salesTransaction )
        {
            $totalAmount = $salesTransaction->total_amount;   
            $totalPaidAmount = $salesTransaction->total_paid_amount;
            $totalUnpaidAmount = $totalAmount - $totalPaidAmount;

            if( $totalAmount != $totalPaidAmount )
            {
                if( $paidAmount <= $totalUnpaidAmount )
                {
                    $sIP = new SalesInstallmentPayment();

                    $sIP->sales_transaction_id = $salesTransaction->id;
                    $sIP->user_id = Auth::user()->id;
                    $sIP->paid_amount = $paidAmount;
                    $sIP->payment_method = $paymentMethod;
                    $sIP->date = date("Y-m-d");

                    foreach( $paymentMethods as $pM )
                    {
                        if( $pM->name == "cheque" )
                        {
                            if( $pM->id == $paymentMethod )
                            {
                                $sIP->cheque_number = $chequeNumber;
                            }
                            break;
                        }
                    }

                    $sIP->save();

                    $sumSIP = SalesInstallmentPayment::where('sales_transaction_id', '=', $salesTransaction->id )->sum('paid_amount');

                    $sT = SalesTransaction::where('id', '=', $salesTransaction->id)->first();

                    $sT->total_paid_amount = $sumSIP;
                    $sT->total_unpaid_amount = $totalAmount - $sumSIP;

                    if( $sumSIP < $totalAmount )
                        $sT->payment_complete_status = 0;
                    else
                        $sT->payment_complete_status = 1;

                    $sT->update();

                    return redirect()->back()->with('successMessage', 'Payment has been made successfully !!!');
                }
                else
                {
                    $sIP = new SalesInstallmentPayment();

                    $sIP->sales_transaction_id = $salesTransaction->id;
                    $sIP->user_id = Auth::user()->id;
                    $sIP->paid_amount = $totalUnpaidAmount;
                    $sIP->payment_method = $paymentMethod;
                    $sIP->date = date("Y-m-d");

                    foreach( $paymentMethods as $pM )
                    {
                        if( $pM->name == "cheque" )
                        {
                            if( $pM->id == $paymentMethod )
                            {
                                $sIP->cheque_number = $chequeNumber;
                            }
                            break;
                        }
                    }

                    $sIP->save();

                    $paidAmount = $paidAmount - $totalUnpaidAmount;

                    $sumSIP = SalesInstallmentPayment::where('sales_transaction_id', '=', $salesTransaction->id )->sum('paid_amount');

                    $sT = SalesTransaction::where('id', '=', $salesTransaction->id)->first();

                    $sT->total_paid_amount = $sumSIP;
                    $sT->total_unpaid_amount = $totalAmount - $sumSIP;

                    if( $sumSIP < $totalAmount )
                        $sT->payment_complete_status = 0;
                    else
                        $sT->payment_complete_status = 1;

                    $sT->update();
                }


            }
        }
        return redirect()->back()->with('unsuccessMessage', 'Payment exceeded !!!, but dont worry, system automatically doesnot pay, more than full amount !!!');

    }


    public function getTransaction($id = '')
    {
        $companyId = $id;

        $salesTransactions = SalesTransaction::where('company_id', '=', $companyId)
                                                ->orderBy('payment_complete_status', 'ASC')
                                                ->orderBy('date', 'DESC')
                                                ->paginate(24);

        $paymentComplete = false;

        $companyName = Company::where('id', '=', $companyId)->first();
        $paymentMethods = PaymentMethod::all();


        return view('salesTransaction.list-company-sales')
                                    ->with('companyName', $companyName)
                                    ->with('paymentMethods', $paymentMethods)
                                    ->with('paymentComplete', $paymentComplete)
                                    ->with('salesTransactions', $salesTransactions);
    }


    public function searchSales(Request $request)
    {
        $companyName = $request['companyName'];

        $searchedSales = SalesTransaction::
                        join('companies', 'sales_transactions.company_id', 'companies.id')
                        ->where('companies.name','LIKE', '%' . $companyName . '%')
                        ->select('sales_transactions.*')
                        ->paginate(24);

        $searchedSales->appends(['companyName' => $companyName ]);

        return view('salesTransaction.searched-sales')
                                ->with('searchedSales', $searchedSales)
                                ->with('companyName', $companyName);
    }



    public function searchDueTransaction(Request $request)
    {
        $dueTransactions = SalesTransaction::with('company')->get();
        $paymentMethods = PaymentMethod::all();

        $countDueTransactions = $dueTransactions->count();

        $officeIdArray = array();
        $tempOfficeDetailArray = array();
        $tempTotalAmount = array();
        $tempTotalPaidAmount = array();
        $tempTotalUnpaidAmount = array();
        $oDA = array();


        for( $i = 0; $i < $countDueTransactions; $i++ )
        {
            if( !in_array( $dueTransactions[$i]->company_id, $officeIdArray ) )
            {
                $officeIdArray[] =  $dueTransactions[$i]->company_id;
                $tempOfficeDetailArray[] = $dueTransactions[$i];
                $oDA[] = $dueTransactions[$i]->toArray();

                $tempTotalAmount[] += $dueTransactions[$i]->total_amount;
                $tempTotalPaidAmount[] += $dueTransactions[$i]->total_paid_amount;
                $tempTotalUnpaidAmount[] += $dueTransactions[$i]->total_unpaid_amount;
            }
            else
            {
                for( $j = 0; $j < count($officeIdArray); $j++ )
                {
                    if( $officeIdArray[$j] == $dueTransactions[$i]->company_id )
                    {
                        $tempTotalAmount[$j] += $dueTransactions[$i]->total_amount; 
                        $tempTotalPaidAmount[$j] += $dueTransactions[$i]->total_paid_amount; 
                        $tempTotalUnpaidAmount[$j] += $dueTransactions[$i]->total_unpaid_amount; 
                        break;
                    }
                }
            }

        }

        $sortedArray = array_multisort( $tempTotalUnpaidAmount, SORT_DESC, $tempTotalAmount, SORT_DESC, $tempTotalPaidAmount, $tempOfficeDetailArray );


        $result = array();

        for( $i = 0; $i < count($tempTotalAmount); $i++ )
        {
            if( $tempTotalUnpaidAmount[$i] > 0 )
            {
                if( stripos($tempOfficeDetailArray[$i]->company->name, $request['companyName']) !== false )
                {
                    $result[] = array(
                                    'officeDetailArray' => $tempOfficeDetailArray[$i],
                                    'totalAmount' => $tempTotalAmount[$i],
                                    'totalPaidAmount' => $tempTotalPaidAmount[$i],
                                    'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
                                );
                }
            }
        }


       $results = $this->paginator( $result, $request->page,"due-transactions/search" );
       $results->appends(['companyName' => $request['companyName']]);

       return view('salesTransaction.searched-due-transactions')
                                                    ->with('results', $results)
                                                    ->with('paymentMethods', $paymentMethods)
                                                    ->with('searchedWord', $request['companyName']);
    }


    public function searchClientTransaction(Request $request)
    {
        $clientTransactions = SalesTransaction::with('company')->get();

        $countClientTransactions = $clientTransactions->count();

        $officeIdArray = array();
        $tempOfficeDetailArray = array();
        $tempTotalAmount = array();
        $tempTotalPaidAmount = array();
        $tempTotalUnpaidAmount = array();
        $oDA = array();


        for( $i = 0; $i < $countClientTransactions; $i++ )
        {
            if( !in_array( $clientTransactions[$i]->company_id, $officeIdArray ) )
            {
                $officeIdArray[] =  $clientTransactions[$i]->company_id;
                $tempOfficeDetailArray[] = $clientTransactions[$i];
                $oDA[] = $clientTransactions[$i]->toArray();

                $tempTotalAmount[] += $clientTransactions[$i]->total_amount;
                $tempTotalPaidAmount[] += $clientTransactions[$i]->total_paid_amount;
                $tempTotalUnpaidAmount[] += $clientTransactions[$i]->total_unpaid_amount;
            }
            else
            {
                for( $j = 0; $j < count($officeIdArray); $j++ )
                {
                    if( $officeIdArray[$j] == $clientTransactions[$i]->company_id )
                    {
                        $tempTotalAmount[$j] += $clientTransactions[$i]->total_amount; 
                        $tempTotalPaidAmount[$j] += $clientTransactions[$i]->total_paid_amount; 
                        $tempTotalUnpaidAmount[$j] += $clientTransactions[$i]->total_unpaid_amount; 
                        break;
                    }
                }
            }

        }

        array_multisort($tempTotalAmount, SORT_DESC, $tempTotalUnpaidAmount, SORT_DESC, $tempOfficeDetailArray, $tempTotalPaidAmount);

        $result = array();

        for( $i = 0; $i < count($tempOfficeDetailArray); $i++ )
        {
            if( stripos($tempOfficeDetailArray[$i]->company->name, $request['companyName']) !== false )
            {
                $result[] = array(
                                'officeDetailArray' => $tempOfficeDetailArray[$i],
                                'totalAmount' => $tempTotalAmount[$i],
                                'totalPaidAmount' => $tempTotalPaidAmount[$i],
                                'totalUnpaidAmount' => $tempTotalUnpaidAmount[$i],
                            );
            }
        }

       $results = $this->paginator( $result, $request->page, "client-transactions/search" );
       $results->appends(['companyName' => $request['companyName']]);

        return view('salesTransaction.searched-client-transactions')
                                        ->with('results', $results)
                                        ->with('paginationNumber', $this->paginationNumber)
                                        ->with('searchedWord', $request['companyName']);
    }

}

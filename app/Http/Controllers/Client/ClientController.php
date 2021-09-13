<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Company\Company;
use App\Models\SalesTransaction\SalesTransaction;
use App\Models\SalesTransaction\SalesTransactionsItem;
use Illuminate\Support\Facades\Validator;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Package\SeoPackage;
use App\Models\Package\AmcPackage;

class ClientController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:client');
    }

    public function showAccountInformation()
    {
    	$companyId = Auth::user()->company_id;
        $seoPackages = SeoPackage::all();
        $amcPackages = AmcPackage::all();

    	$salesTransactions = SalesTransaction::with('salesTransactionsItem.salesCategory', 'salesTransactionsItemFb')
    											->where('company_id', '=', $companyId)
    											->orderBy('date', 'DESC')
    											->get();

        $company = Company::where('id', '=', $companyId)->first();

    	$totalAmount = SalesTransaction::where('company_id', '=', $companyId)
    										->sum('total_amount');

    	$totalPaidAmount = SalesTransaction::where('company_id', '=', $companyId)
    										->sum('total_paid_amount');

    	$dueAmount = SalesTransaction::where('company_id', '=', $companyId)
    										->sum('total_unpaid_amount');


    	// dd($salesTransactions);

    	return view('client.show-account-information')
    										->with('salesTransactions', $salesTransactions)
    										->with('totalAmount', $totalAmount)
    										->with('totalPaidAmount', $totalPaidAmount)
    										->with('dueAmount', $dueAmount)
                                            ->with('seoPackages', $seoPackages)
                                            ->with('amcPackages', $amcPackages)
                                            ->with('company', $company);
    }


    public function changePasswordForm()
    {
        return view('client.change-password-form');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|confirmed|min:6|max:30',

            ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        $oldPassword = Auth::user()->password;
        $clientId = Auth::user()->id;

        if( Hash::check($request['oldPassword'], $oldPassword) )
        {
            $client = User::where('id', '=', $clientId)->first();

            $client->password = bcrypt($request['newPassword']);

            $client->save();
            
        }
        else
        {
            return redirect()->back()->with('unsuccessMessage', 'Old Password does not match !!!');
        }

        return redirect()->back()->with('successMessage', 'Password changed successfully !!!');

    }
}

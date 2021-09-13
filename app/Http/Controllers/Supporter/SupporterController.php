<?php

namespace App\Http\Controllers\Supporter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Access\User\User;
use App\Models\SalesTransaction\SalesTransaction;

class SupporterController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->middleware('role:supporter');
    }

    public function showProjectInformation()
    {
    	$supporterId = Auth::user()->id;

    	$salesTransactions = SalesTransaction::with('company')
											->where('referred_by', '=', $supporterId)
											->get();
    	// dd($salesTransactions);

		$totalAmount = SalesTransaction::where('referred_by', '=', $supporterId)
											->sum('total_amount');

    	return view('supporter.show-project-information')
    					->with('salesTransactions', $salesTransactions)
    					->with('totalAmount', $totalAmount);
    }


    public function changePasswordForm()
    {
        return view('supporter.change-password-form');
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
        $supporterId = Auth::user()->id;

        if( Hash::check($request['oldPassword'], $oldPassword) )
        {
            $client = User::where('id', '=', $supporterId)->first();

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

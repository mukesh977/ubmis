<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';
	protected $redirectAfterLogout = '/';
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	public function showLoginForm() {
		return view('auth.login');
	}

	public function login(Request $request)
	{

		try {
			//Retrieving users data
			$email = $request->get('email');
			$password = $request->get('password');
			$validator = Validator::make($request->all(),[
				'email' => 'required|email',
				'password' => 'required'
			]);

			if($validator->fails()){
				return redirect('/')->withInputs($request->all())->withErrors($validator);
			}

			if (Auth::attempt(['email' => $email, 'password' => $password])) {
				if(Auth::user()->hasRole('admin')){
					return redirect()->route('admin.dashboard');
				}else{
					return redirect()->route('home');
				}
			}

			return redirect()->back()
			                 ->withInput($request->only('email'))
			                 ->withErrors([
				                 'email' =>'These credentials do not match our records.',
			                 ]);
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}
}

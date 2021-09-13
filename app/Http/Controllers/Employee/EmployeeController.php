<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\EmployeeDetail;
use App\Models\Access\User\User;
use App\Models\Access\Role\Role;

class EmployeeController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function create($id="")
    {
    	$roles =  Role::whereNotIn('name', ['admin', 'client'])->get();

    	if( $id != "")
    	{
    		$editEmployee = EmployeeDetail::where('id', '=', $id)->first();
    		// dd($employee);

    		return view('employeeDetail.registration-form')
    					->with('editEmployee', $editEmployee)
    					->with('roles', $roles);
    	}

		return view('employeeDetail.registration-form')->with('roles', $roles);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
	        'name' => 'required|string',
	        'dateOfBirth' => 'required|string',
	        'email' => 'required|string',
	        'mobileNumber' => 'required|string',
	        'phoneNumber' => 'required|string',
	        'tAddress' => 'required|string',
	        'tTole' => 'required|string',
	        'tWard' => 'required|string',
	        'pAddress' => 'required|string',
	        'pTole' => 'required|string',
	        'pWard' => 'required|string',
	        'fb' => 'required|string',
	        'twitter' => 'required|string',
	        'personalWebsite' => 'required|string',
	        'bankName1' => 'required|string',
	        'swiftCode1' => 'required|string',
	        'bankNumber1' => 'required|string',
	        'branch1' => 'required|string',
	        'fatherName' => 'required|string',
	        'motherName' => 'required|string',
	        'grandFatherName' => 'required|string',
	        'grandMotherName' => 'required|string',
	        'brotherName' => 'required|string',
	        'bloodGroup' => 'required|string',
	        'esewaId' => 'required|string',
	        'education' => 'required|string',
	        'collegeName' => 'required|string',
	        'role' => 'required|string',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        if( empty($request['employeeId']))
        {
	        try
	        {
		        $employee = new EmployeeDetail();

		        $employee->name = $request['name'];
		        $employee->date_of_birth = $request['dateOfBirth'];
		        $employee->email = $request['email'];
		        $employee->mobile_number = $request['mobileNumber'];
		        $employee->phone_number = $request['phoneNumber'];
		        $employee->temporary_address = $request['tAddress'];
		        $employee->temporary_tole = $request['tTole'];
		        $employee->temporary_ward = $request['tWard'];
		        $employee->permanent_address = $request['pAddress'];
		        $employee->permanent_tole = $request['pTole'];
		        $employee->permanent_ward = $request['pWard'];
		        $employee->fb_link = $request['fb'];
		        $employee->twitter_link = $request['twitter'];
		        $employee->personal_website_link = $request['personalWebsite'];
		        $employee->bank_name_1 = $request['bankName1'];
		        $employee->swift_code_1 = $request['swiftCode1'];
		        $employee->bank_number_1 = $request['bankNumber1'];
		        $employee->branch_1 = $request['branch1'];

		        if(!empty($request['bankName2']))
			        $employee->bank_name_2 = $request['bankName2'];

		        if(!empty($request['swiftCode2']))
			        $employee->swift_code_2 = $request['swiftCode2'];

		        if(!empty($request['bankNumber2']))
			        $employee->bank_number_2 = $request['bankNumber2'];

		        if(!empty($request['branch2']))
			        $employee->branch_2 = $request['branch2'];


		        $employee->father_name = $request['fatherName'];
		        $employee->mother_name = $request['motherName'];
		        $employee->grandfather_name = $request['grandFatherName'];
		        $employee->grandmother_name = $request['grandMotherName'];
		        $employee->brother_name = $request['brotherName'];
		        $employee->blood_group = $request['bloodGroup'];
		        $employee->esewa_id = $request['esewaId'];
		        $employee->education = $request['education'];
		        $employee->college_name = $request['collegeName'];
		        $employee->role_id = $request['role'];

		        if(!empty($request['password']))
		        {
		        	$user = new User();
					
					$name = explode(' ', $request['name'], 2);
		        	$user->first_name = $name[0];

		        	if(!empty($name[1]))
			        	$user->last_name = $name[1];

		        	$user->email = $request['email'];
		        	$user->password = bcrypt($request['password']);

		        	$user->save();

		        	$user->roles()->attach($request['role']);

			        $employee->user_id = $user->id;
		        }


		        $employee->save();
	        	
	        }
	        catch( \Exception $e )
	        {
	        	return redirect()->back()->with('unsuccessMessage', 'Failed to add new employee !!!');
	        }

	        return redirect()->back()->with('successMessage', 'New Employee Added Successfully !!!');
        	
        }

        else
        {
        	try	
        	{
	        	$employee = EmployeeDetail::where('id', '=', $request['employeeId'])->first();

		        $employee->name = $request['name'];
		        $employee->date_of_birth = $request['dateOfBirth'];
		        $employee->email = $request['email'];
		        $employee->mobile_number = $request['mobileNumber'];
		        $employee->phone_number = $request['phoneNumber'];
		        $employee->temporary_address = $request['tAddress'];
		        $employee->temporary_tole = $request['tTole'];
		        $employee->temporary_ward = $request['tWard'];
		        $employee->permanent_address = $request['pAddress'];
		        $employee->permanent_tole = $request['pTole'];
		        $employee->permanent_ward = $request['pWard'];
		        $employee->fb_link = $request['fb'];
		        $employee->twitter_link = $request['twitter'];
		        $employee->personal_website_link = $request['personalWebsite'];
		        $employee->bank_name_1 = $request['bankName1'];
		        $employee->swift_code_1 = $request['swiftCode1'];
		        $employee->bank_number_1 = $request['bankNumber1'];
		        $employee->branch_1 = $request['branch1'];

		        if(!empty($request['bankName2']))
			        $employee->bank_name_2 = $request['bankName2'];

		        if(!empty($request['swiftCode2']))
			        $employee->swift_code_2 = $request['swiftCode2'];

		        if(!empty($request['bankNumber2']))
			        $employee->bank_number_2 = $request['bankNumber2'];

		        if(!empty($request['branch2']))
			        $employee->branch_2 = $request['branch2'];


		        $employee->father_name = $request['fatherName'];
		        $employee->mother_name = $request['motherName'];
		        $employee->grandfather_name = $request['grandFatherName'];
		        $employee->grandmother_name = $request['grandMotherName'];
		        $employee->brother_name = $request['brotherName'];
		        $employee->blood_group = $request['bloodGroup'];
		        $employee->esewa_id = $request['esewaId'];
		        $employee->education = $request['education'];
		        $employee->college_name = $request['collegeName'];
		        $employee->role_id = $request['role'];

		        if(!empty($request['password']))
		        {
		        	$existUser = EmployeeDetail::where('id', '=', $request['employeeId'])->first()->user_id;

		        	if( $existUser == NULL )
		        	{
			        	$user = new User();
						
						$name = explode(' ', $request['name'], 2);
			        	$user->first_name = $name[0];

			        	if(!empty($name[1]))
				        	$user->last_name = $name[1];

			        	$user->email = $request['email'];
			        	$user->password = bcrypt($request['password']);

			        	$user->save();

			        	$user->roles()->attach($request['role']);

				        $employee->user_id = $user->id;
		        		
		        	}
		        	else
		        	{
		        		$user = User::where('id', '=', $existUser)->first();

		        		dd($user);
		        		$user->password = bcrypt($request['password']);
						// $user->roles()->attach($request['role']);		        		

		        		$user->update();
		        	}
		        }


		        $employee->update();
        	}
        	catch( \Exception $e )
        	{
        		return redirect()->back()->with('unsuccessMessage', 'Failed to edit employee detail !!!');
        	}	
        	
	        
	        return redirect()->back()->with('successMessage', 'Employee Edited Successfully !!!');
        }

    }


    public function show()
    {
    	$employees = EmployeeDetail::paginate(24);
    	// dd($employees);

    	return view('employeeDetail.list-employees')->with('employees', $employees);
    }

    public function destroy(Request $request)
    {
    	$deleteEmployee = $request['employee_id_delete'];

    	try
    	{
	    	$delete = EmployeeDetail::where('id', '=', $deleteEmployee)->delete();
    	}
    	catch( \Exception $e )
    	{
    		return redirect()->back()->with('unsuccessMessage', 'Failed to delete employee !!!');
    	}

    	return redirect()->back()->with('successMessage', 'Employee deleted successfully !!!');
    }


    public function showIndividualEmployee($id)
    {
    	$individualEmployee = EmployeeDetail::with('role')->where('id', '=', $id)->first();

    	// dd($individualEmployee);

    	return view('employeeDetail.individual-employee')->with('individualEmployee', $individualEmployee);
    }


}

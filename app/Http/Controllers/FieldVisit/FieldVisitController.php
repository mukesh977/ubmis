<?php

namespace App\Http\Controllers\FieldVisit;

use App\Http\Requests\FieldVisit\VisitRequest;
use App\Models\Company\Company;
use App\Models\FieldVisit\ContactDetail;
use App\Models\FieldVisit\VisitorDetail;
use App\Models\Targets\UserTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FieldVisit\FieldVisit;
use App\Models\Targets\Target;
use App\Models\VisitCategory\VisitCategory;
use App\Models\Email\Email;
use App\Models\ContactNumber\ContactNumber;
use Illuminate\Support\Facades\Auth;
use App\Models\Access\User\User;

class FieldVisitController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $users = ( new FieldVisit())->getUserForVisitAssign();

	    $user_id = Auth::user()->id;
        $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo', 'companies')
                                ->whereHas('targets', function($query){
                                	$query->where('name', '=', 'Daily');
                                })
                                ->where('user_id', $user_id)
                                ->orderBy('date', 'DESC')
                                ->orderBy('id', 'DESC')
                                ->get();

        return view('fieldVisits.index', compact('visitDatas', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $targets = Target::all();
        $visitCategories = VisitCategory::all();
        $companies = Company::all();

        return view('fieldVisits.create')->with('targets', $targets)->with('visitCategories', $visitCategories)->with('companies', $companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitRequest $request)
    {
    	$target = Target::where('name', '=', 'Daily')->first();
	    $visitDatas = new FieldVisit();
	    $visitDatas->user_id = Auth::user()->id;
	    $visitDatas->targets_id = $target->id;
	    $visitDatas->visit_category_id = $request->visit_category_id;
	    $visitDatas->company_id = $request->company_id;
   		$visitDatas->date = date("Y-m-d", strtotime($request->date));
   		$visitDatas->email_address = $request->email_address;
   		$visitDatas->address = $request->address;
   		$visitDatas->visited_to = $request->visited_to;
   		$visitDatas->contact_person = $request->contact_person;
   		$visitDatas->requirements = $request->requirements;

   		if( $request->next_visit_date != NULL )
	   		$visitDatas->next_visit_date = date("Y-m-d", strtotime($request->next_visit_date));
	   	else
	   		$visitDatas->next_visit_date = NULL;

   		$visitDatas->project_status = $request->project_status;
	    $visitDatas->project_scope = $request->project_scope;
   		$visitDatas->reasons = $request->reasons;
   		$visitDatas->weakness = $request->weakness;
   		$visitDatas->comments = $request->comments;
   		$visitDatas->save();


   		$availableEmail2 = Email::where('company_id', '=', $request->company_id)->get();

   		ContactNumber::where('field_visit_id', '=', $visitDatas->id)->delete();
   		$this->storeContact($request->company_id, $visitDatas->id, $request->visitors_contact);
   		$this->storeContact($request->company_id, $visitDatas->id, $request->contact_number);

   		if( $availableEmail2->isEmpty() )
   		{
	   		$primaryEmail = new Email();

	   		$primaryEmail->field_visit_id = $visitDatas->id;
	   		$primaryEmail->company_id = $request->company_id;
	   		$primaryEmail->email = $request->email_address;
	   		$primaryEmail->type = "primary";

	   		$primaryEmail->save();
   			
   		}
   		else
   		{
   			$primaryEmail = Email::where('company_id', '=', $request->company_id)
   									->where('type', '=', 'primary')
   									->first();

   			if( $primaryEmail->email != $request->email_address )
   			{
		   		$primaryEmail->email = $request->email_address;
		   		$primaryEmail->update();
   			}
   		}

	    /*
	     * Insert Visitors Details
	     */
		if(count($request->visitors_contact) > count($request->visitors_email)){
			$count = count($request->visitors_contact);
		}else{
			$count = count($request->visitors_email);
		}

		$visitors_contact = $request->visitors_contact;
		$visitors_email = $request->visitors_email;
	    for($i = 0; $i < $count; $i++){
		    $data['visitors_contact'] = isset($visitors_contact[$i]) ? $visitors_contact[$i] : '';
		    $data['visitors_email'] = isset($visitors_email[$i]) ? $visitors_email[$i] : '';
		    $data['field_visit_id'] = $visitDatas->id;

		    VisitorDetail::create($data);
	    }

	    $availableEmail = Email::where('company_id', '=', $request->company_id)->get();
	    $flag = 0;
	    // dd($availableEmail);

	    if( $availableEmail->isEmpty() )
	    {
	    	// dd('hy');
	    	if( !empty($request->visitors_email) )
	    	{
			    foreach( $request->visitors_email as $email )
			    {
				    $secondaryEmail1 = new Email();

				    $secondaryEmail1->field_visit_id = $visitDatas->id;
				    $secondaryEmail1->company_id = $request->company_id;
				    $secondaryEmail1->email = $email;
				    $secondaryEmail1->type = "secondary";

				    $secondaryEmail1->save();
			    	
			    }
	    		
	    	}
	    }
	    else
	    {
	    	foreach( $request->visitors_email as $email )
	    	{
	    		foreach( $availableEmail as $aEmail )
	    		{
	    			if( $email == $aEmail->email )
	    			{
	    				$flag = 1;
	    			}
	    		}

	    		if( $flag == 0 )
	    		{
	    			$secondaryEmail1 = new Email();

				    $secondaryEmail1->field_visit_id = $visitDatas->id;
				    $secondaryEmail1->company_id = $request->company_id;
				    $secondaryEmail1->email = $email;
				    $secondaryEmail1->type = "secondary";

				    $secondaryEmail1->save();

	    		}
			    
			    $flag = 0;
	    	}
	    }


	    /*
	     *  Insert Contact Details
	     */
	    $contact_number = $request->contact_number;
	    $contact_email = $request->contact_email;
	    if(count($contact_number) > count($contact_email)){
	    	$count1 = count($contact_number);
	    }else{
	    	$count1 = count($contact_email);
	    }

	    for($i = 0; $i < $count1; $i++){
		    $data['contact_number'] = isset($contact_number[$i]) ? $contact_number[$i] : '';
		    $data['contact_email'] = isset($contact_email[$i]) ? $contact_email[$i] : '';
		    $data['field_visit_id'] = $visitDatas->id;

		    ContactDetail::create($data);
	    }



	    $flag2 = 0;

	    if( $availableEmail->isEmpty() )
	    {
	    	if( !empty($request->contact_email) )
	    	{
			    foreach( $request->contact_email as $email )
			    {
				    $secondaryEmail2 = new Email();

				    $secondaryEmail2->field_visit_id = $visitDatas->id;
				    $secondaryEmail2->company_id = $request->company_id;
				    $secondaryEmail2->email = $email;
				    $secondaryEmail2->type = "secondary";

				    $secondaryEmail2->save();
			    	
			    }
	    		
	    	}
	    }
	    else
	    {
	    	foreach( $request->contact_email as $email )
	    	{
	    		foreach( $availableEmail as $aEmail )
	    		{
	    			if( $email == $aEmail->email )
	    			{
	    				$flag2 = 1;
	    			}
	    		}

	    		if( $flag2 == 0 )
	    		{
	    			$secondaryEmail2 = new Email();

				    $secondaryEmail2->field_visit_id = $visitDatas->id;
				    $secondaryEmail2->company_id = $request->company_id;
				    $secondaryEmail2->email = $email;
				    $secondaryEmail2->type = "secondary";

				    $secondaryEmail2->save();

	    		}
			    
			    $flag2 = 0;
	    	}
	    }

	    $userId = Auth::user()->id;
	    $daily = Carbon::now()->toDateString();
	    $visitDataCount = FieldVisit::where('user_id', $userId)
		                            ->where('date', $daily)->count();
	    $target = Target::where('name', '=', 'Daily')->first();
	    $userTarget = UserTarget::where('target_id', $target->id)
		                        ->where('user_id', $userId)->first();

		// dd($userTarget);

		if( $userTarget != null ) 
		{
		    if($visitDataCount >= $userTarget->total_target){
		    	$message = 'Congratulation !!! You Are Doing Good. Keep It Up.';
		    }else{
		    	$message = 'You Are Lacking In Target, Need More !!! ';
		    }

		    return redirect()->route('daily-field-visits.index')->with('success', 'Successfully Created New Visit')->with('message', $message);
		}


   		return redirect()->route('daily-field-visits.index')->with('success', 'Successfully Created New Visit');
    }


    public function storeContact($companyId, $visitId, array $contacts)
    {
    	$availableContact = ContactNumber::where('contact_number_type', '=', 'company')
   											->where('contact_number_id', '=', $companyId)
   											->get();

    	// dd($availableContact);
   		$flag = 0;

	    if( $availableContact->isEmpty() )
	    {
	    	if( !empty($contacts) )
	    	{
			    foreach( $contacts as $contact )
			    {
				    $contactNumber = new ContactNumber();

				    $contactNumber->field_visit_id = $visitId;
				    $contactNumber->contact_number = $contact;
				    $contactNumber->contact_number_id = $companyId;
				    $contactNumber->contact_number_type = "company";

				    $contactNumber->save();
			    	
			    }
	    		
	    	}
	    }
	    else
	    {
	    	foreach( $contacts as $contact )
	    	{
	    		foreach( $availableContact as $aContact )
	    		{
	    			if( $contact == $aContact->contact_number )
	    			{
	    				$flag = 1;
	    			}
	    		}

	    		if( $flag == 0 )
	    		{
	    			$contactNumber = new ContactNumber();

				    $contactNumber->field_visit_id = $visitId;
				    $contactNumber->contact_number = $contact;
				    $contactNumber->contact_number_id = $companyId;
				    $contactNumber->contact_number_type = "company";
				    
				    $contactNumber->save();

	    		}
			    
			    $flag = 0;
	    	}
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','contactDetails','visitorDetails','fieldVisitAssignedBy', 'fieldVisitAssignedTo', 'companies')->where('id', $id)->orderBy('date', 'DESC')->first();

	    return view('fieldVisits.show', compact('visitDatas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $targets = Target::all();
	    $visitCategories = VisitCategory::all();
	    $companies = Company::all();

	    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','contactDetails','visitorDetails')->where('id', $id)->first();
	    // dd($visitDatas);

        return view('fieldVisits.edit', compact('visitDatas', 'targets', 'visitCategories', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitRequest $request, $id)
    {
        $visitDatas = FieldVisit::find($id);
	    $target = Target::where('name', '=', 'Daily')->first();
        $datas = [
	        'user_id' => Auth::user()->id,
	        'targets_id' => $target->id,
	        'visit_category_id' => $request->visit_category_id,
	        'company_id' => $request->company_id,
	        'date' => date("Y-m-d", strtotime($request->date)),
	        'office_name' => $request->office_name,
	        'email_address' => $request->email_address,
	        'address' => $request->address,
	        'visited_to' => $request->visited_to,
	        'contact_person' => $request->contact_person,
	        'requirements' => $request->requirements,
	        'next_visit_date' => ($request->next_visit_date != NULL)? date("Y-m-d", strtotime($request->next_visit_date)) : NULL,
	        'project_status' => $request->project_status,
	        'project_scope' => $request->project_scope,
	        'reasons' => $request->targets_id,
	        'weakness' => $request->weakness,
	        'comments' => $request->comments
        ];

        $visitDatas->update($datas);

        $deleteEmail = Email::where('field_visit_id', '=', $visitDatas->id)->delete();

        $primaryEmail = new Email();

   		$primaryEmail->field_visit_id = $visitDatas->id;
   		$primaryEmail->company_id = $request->company_id;
   		$primaryEmail->email = $request->email_address;
   		$primaryEmail->type = "primary";

   		$primaryEmail->save();

   		ContactNumber::where('field_visit_id', '=', $visitDatas->id)->delete();
   		$this->storeContact($request->company_id, $visitDatas->id, $request->visitors_contact);
   		$this->storeContact($request->company_id, $visitDatas->id, $request->contact_number);

   		$availableEmail = Email::where('company_id', '=', $request->company_id)->get();

   		$flag = 0;

	    if( $availableEmail->isEmpty() )
	    {
	    	if( !empty($request->visitors_email) )
	    	{
			    foreach( $request->visitors_email as $email )
			    {
				    $secondaryEmail1 = new Email();

				    $secondaryEmail1->field_visit_id = $visitDatas->id;
				    $secondaryEmail1->company_id = $request->company_id;
				    $secondaryEmail1->email = $email;
				    $secondaryEmail1->type = "secondary";

				    $secondaryEmail1->save();
			    	
			    }
	    		
	    	}
	    }
	    else
	    {
	    	foreach( $request->visitors_email as $email )
	    	{
	    		foreach( $availableEmail as $aEmail )
	    		{
	    			if( $email == $aEmail )
	    			{
	    				$flag = 1;
	    			}
	    		}

	    		if( $flag == 0 )
	    		{
	    			$secondaryEmail1 = new Email();

				    $secondaryEmail1->field_visit_id = $visitDatas->id;
				    $secondaryEmail1->company_id = $request->company_id;
				    $secondaryEmail1->email = $email;
				    $secondaryEmail1->type = "secondary";

				    $secondaryEmail1->save();

	    		}
			    
			    $flag = 0;
	    	}
	    }


	    $flag2 = 0;

	    if( $availableEmail->isEmpty() )
	    {
	    	if( !empty($request->contact_email) )
	    	{
			    foreach( $request->contact_email as $email )
			    {
				    $secondaryEmail2 = new Email();

				    $secondaryEmail2->field_visit_id = $visitDatas->id;
				    $secondaryEmail2->company_id = $request->company_id;
				    $secondaryEmail2->email = $email;
				    $secondaryEmail2->type = "secondary";

				    $secondaryEmail2->save();
			    	
			    }
	    		
	    	}
	    }
	    else
	    {
	    	foreach( $request->contact_email as $email )
	    	{
	    		foreach( $availableEmail as $aEmail )
	    		{
	    			if( $email == $aEmail )
	    			{
	    				$flag2 = 1;
	    			}
	    		}

	    		if( $flag2 == 0 )
	    		{
	    			$secondaryEmail2 = new Email();

				    $secondaryEmail2->field_visit_id = $visitDatas->id;
				    $secondaryEmail2->company_id = $request->company_id;
				    $secondaryEmail2->email = $email;
				    $secondaryEmail2->type = "secondary";

				    $secondaryEmail2->save();

	    		}
			    
			    $flag2 = 0;
	    	}
	    }

	    /*
	     *  Update Visitors Dedtails
	     */
	    if(count($request->visitors_contact) > count($request->visitors_email)){
		    $count = count($request->visitors_contact);
	    }else{
		    $count = count($request->visitors_email);
	    }



	    $visitors_contact = $request->visitors_contact;
	    $visitors_email = $request->visitors_email;
	    VisitorDetail::where('field_visit_id', $visitDatas->id)->delete();
	    for($i = 0; $i < $count; $i++){
		    $data['visitors_contact'] = isset($visitors_contact[$i]) ? $visitors_contact[$i] : '';
		    $data['visitors_email'] = isset($visitors_email[$i]) ? $visitors_email[$i] : '';
		    $data['field_visit_id'] = $visitDatas->id;

		    VisitorDetail::create($data);
	    }

	    /*
	     *  Update Contacts Details
	     */
	    $contact_number = $request->contact_number;
	    $contact_email = $request->contact_email;
	    if(count($contact_number) > count($contact_email)){
		    $count1 = count($contact_number);
	    }else{
		    $count1 = count($contact_email);
	    }

	    ContactDetail::where('field_visit_id', $visitDatas->id)->delete();
	    for($i = 0; $i < $count1; $i++){
		    $data['contact_number'] = isset($contact_number[$i]) ? $contact_number[$i] : '';
		    $data['contact_email'] = isset($contact_email[$i]) ? $contact_email[$i] : '';
		    $data['field_visit_id'] = $visitDatas->id;

		    ContactDetail::create($data);
	    }

        return redirect()->route('daily-field-visits.index')->with('success', 'Successfully Updated Field Visits.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FieldVisit::where('id', $id)->delete();

        return response()->json(['success' => 'Delete Success']);
    }

    public function getAllFieldVisits()
    {
	    $users = ( new FieldVisit())->getUserForVisitAssign();

	    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')->orderBy('date', 'DESC')->get();

	    return view('fieldVisits.index', compact('visitDatas', 'users'));
    }

    public function assignedUserToFieldVisit(Request $request, $id)
    {
		FieldVisit::where('id', $id)->update([
			'assigned_to' => $request->user_id,
			'assigned_by' => Auth::user()->id,
			'assigned_date' => Carbon::now()
		]);

		return response()->json(['success' => 'Successfully assigned field visit.']);
    }

    public function getAssignedFieldVisits()
    {
    	$authId = Auth::user()->id;
	    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
	                            ->where('assigned_to', $authId)
	                            ->orderBy('date', 'DESC')
	                            ->get();
	                            // dd($visitDatas);

	    return view('fieldVisits.index', compact('visitDatas'));
    }

    public function getAssignedPositiveFieldVisits()
    {
    	$authId = Auth::user()->id;
    	$user = User::with('roles')->where('id', '=', $authId)->first();
    	$users = ( new FieldVisit() )->getUserForVisitAssign();

    	if( $user->roles[0]->name == 'admin' )
    	{
		    $visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
		                            ->where('project_status', 1)
		                            ->orderBy('date', 'DESC')
		                            ->get();
    	}
    	else
    	{
    		$visitDatas = FieldVisit::with('users', 'targets', 'visitCategories','fieldVisitAssignedTo')
		                            ->where('user_id', $authId)
		                            ->where('project_status', 1)
		                            ->orderBy('date', 'DESC')
		                            ->get();
    	}

        // dd($visitDatas);

	    return view('fieldVisits.positive-follow-ups', compact('visitDatas', 'users'));
    }


    public function getCalenderWorkloads()
    {
    	$authId = Auth::user()->id;
	    $visitDatas = FieldVisit::with('companies')
	                            ->where('assigned_to', $authId)
	                            ->orderBy('date', 'DESC')
	                            ->get();
    	// dd($visitDatas);

    	return view('calendar.calendar-workloads')->with('visitDatas', $visitDatas);
    }
}

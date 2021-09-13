<?php

namespace App\Http\Controllers\FieldVisit;

use App\Http\Requests\FieldVisit\NextFieldVisitRequest;
use App\Models\Company\Company;
use App\Models\FieldVisit\ContactDetail;
use App\Models\FieldVisit\FieldVisit;
use App\Models\FieldVisit\VisitorDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NextFieldVisitController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$companies = Company::all();

	    return view('fieldVisits.partials.create-next-field-visit', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NextFieldVisitRequest $request)
    {
    	$datas = FieldVisit::where('company_id', $request->company_id)->orderBy('id', 'desc')->first();
	    $visitDatas = new FieldVisit();
	    $visitDatas->user_id = Auth::user()->id;
	    $visitDatas->targets_id = $datas->targets_id;
	    $visitDatas->visit_category_id = $datas->visit_category_id;
	    $visitDatas->company_id = $request->company_id;
	    $visitDatas->date = date("Y-m-d", strtotime($request->date));
	    $visitDatas->email_address = $datas->email_address;
        $visitDatas->address = $datas->address;
	    $visitDatas->visited_to = $datas->visited_to;
	    $visitDatas->contact_person = $datas->contact_person;
	    $visitDatas->requirements = $datas->requirements;
	    $visitDatas->next_visit_date = date("Y-m-d", strtotime($request->next_visit_date));
	    $visitDatas->project_status = $datas->project_status;
	    $visitDatas->project_scope = $datas->project_scope;
	    $visitDatas->reasons = $datas->reasons;
	    $visitDatas->weakness = $datas->weakness;
	    $visitDatas->comments = $datas->comments;
	    $visitDatas->next_visit_comments = $request->next_visit_comments;
	    $visitDatas->save();

	    $visitorDetails = VisitorDetail::where('field_visit_id', $datas->id)->get();
	    $contactDetails = ContactDetail::where('field_visit_id', $datas->id)->get();

	    foreach($visitorDetails as $detail){
		    $data['visitors_contact'] = $detail->visitors_contact;
		    $data['visitors_email'] = $detail->visitors_email;
		    $data['field_visit_id'] = $visitDatas->id;

		    VisitorDetail::create($data);
	    }

	    foreach($contactDetails as $detail){
		    $data['contact_number'] = $detail->contact_number;
		    $data['contact_email'] = $detail->contact_email;
		    $data['field_visit_id'] = $visitDatas->id;

		    ContactDetail::create($data);
	    }

        return redirect()->route('daily-field-visits.index')->with('success', 'Next Field Visit Data Is Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

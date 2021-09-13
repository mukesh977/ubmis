<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests\Company\CompanyRequest;
use App\Models\Company\Company;
use App\Models\Email\Email;
use App\Models\ContactNumber\ContactNumber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCompanies = Company::orderBy('name', 'ASC')->paginate(24);

        return view('company.list-company')->with('listCompanies', $listCompanies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.add-company');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->save();

        return response()->json(['data' => $company, 'message' => 'New office is created successfully.']);
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
        $editCompany = Company::with('emails', 'contactNumbers')->where('id', '=', $id)->first();
        // dd($editCompany);

        return view('company.add-company')->with('editCompany', $editCompany);
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
    public function destroy(Request $request)
    {
        try
        {
            Company::where('id', '=', $request['company_id_delete'])->delete();

            Email::where('company_id', '=', $request['company_id_delete'])->delete();

            ContactNumber::where('contact_number_id', '=', $request['company_id_delete'])
                            ->where('contact_number_type', '=', 'company')
                            ->delete();
        }
        catch( \Exception $e )
        {
            return redirect()->back()->with('unsuccessMessage', 'Failed to delete office !!!');
        }

        return redirect()->back()->with('successMessage', 'Office deleted successfully !!!');
    }

    public function storeOfficeSales(Request $request)
    {
        if($request->ajax())
        {
            
            $company = new Company();

            $company->name = $request->name;
            $company->address = $request->address;

            $company->save();


            foreach( $request['contactNumbers'] as $contactNumber)
            {
                $cN = new ContactNumber();

                $cN->contact_number = $contactNumber;
                $cN->contact_number_id = $company->id;
                $cN->contact_number_type = "company";

                $cN->save();

            }


            $count = count($request['emails']);

            for( $i = 0; $i < $count; $i++ )
            {
                if( $i == 0 )
                {
                    $e = new Email();

                    $e->company_id = $company->id;
                    $e->email = $request['emails'][$i];
                    $e->type = "primary";

                    $e->save();
                }
                else
                {
                    $e = new Email();

                    $e->company_id = $company->id;
                    $e->email = $request['emails'][$i];
                    $e->type = "secondary";

                    $e->save();
                }
            }

            return response()->json(['data' => $company, 'message' => 'New office added successfully !!!']);
        }
    }

    public function storeCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            // 'address' => 'required|string',
            'email.*' => 'required|email|string',
            'contactNumber.*' => 'required|string',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        if( $request['companyId'] == '' )
        {
            try
            {
                $company = new Company();

                $company->name = $request['name'];
                $company->address = $request['address'];

                $company->save();


                $count1 = count($request['email']);

                for( $i = 0; $i < $count1; $i++ )
                {
                    $email = new Email();

                    if( $i == 0 )
                    {
                        $email = new Email();

                        $email->company_id = $company->id;
                        $email->email = $request['email'][$i];
                        $email->type = "primary";

                        $email->save();
                    }
                    else
                    {
                        $email = new Email();

                        $email->company_id = $company->id;
                        $email->email = $request['email'][$i];
                        $email->type = "secondary";

                        $email->save();
                    }
                }

                $count2 = count($request['contactNumber']);

                for( $i = 0; $i < $count2; $i++ )
                {
                    $contact = new ContactNumber();

                    $contact->contact_number = $request['contactNumber'][$i];
                    $contact->contact_number_id = $company->id;
                    $contact->contact_number_type = "company";

                    $contact->save();
                }
            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to create new office !!!');
            }

        return redirect()->back()->with('successMessage', 'New office added successfully !!!');
        }
        else
        {
            try
            {
                Email::where('company_id', '=', $request['companyId'])->delete();
               
                ContactNumber::where('contact_number_type', '=', 'company')
                                ->where('contact_number_id', '=', $request['companyId'])
                                ->delete();

                $company = Company::where('id', '=', $request['companyId'])->first();

                $company->name = $request['name'];
                $company->address = $request['address'];

                $company->update();


                $count1 = count($request['email']);

                for( $i = 0; $i < $count1; $i++ )
                {
                    $email = new Email();

                    if( $i == 0 )
                    {
                        $email = new Email();

                        $email->company_id = $company->id;
                        $email->email = $request['email'][$i];
                        $email->type = "primary";

                        $email->save();
                    }
                    else
                    {
                        $email = new Email();

                        $email->company_id = $company->id;
                        $email->email = $request['email'][$i];
                        $email->type = "secondary";

                        $email->save();
                    }
                }

                $count2 = count($request['contactNumber']);

                for( $i = 0; $i < $count2; $i++ )
                {
                    $contact = new ContactNumber();

                    $contact->contact_number = $request['contactNumber'][$i];
                    $contact->contact_number_id = $company->id;
                    $contact->contact_number_type = "company";

                    $contact->save();
                }
            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to edit office !!!');
            }

        return redirect()->back()->with('successMessage', 'Office edited successfully !!!');  
        }

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


    public function searchCompany(Request $request)
    {
        $companyName = $request['companyName'];

        $searchedCompanies = Company::with('contactNumbers', 'emails')
                            ->where('name', 'LIKE', '%' . $companyName . '%')
                            ->paginate(24);

        $searchedCompanies->appends(['companyName' => $companyName]);
        return view('company.search-company')->with('searchedCompanies', $searchedCompanies)
                                             ->with('searchedWord', $companyName);
    }
}

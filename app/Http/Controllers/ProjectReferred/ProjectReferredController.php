<?php

namespace App\Http\Controllers\ProjectReferred;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SalesTransaction\SalesTransaction;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectReferred\ProjectReferredRelationship;

class ProjectReferredController extends Controller
{
	public function index()
	{
		$salesTransactions = SalesTransaction::with('referredBy')->get();
		$projectReferred = ProjectReferredRelationship::with('parent')->get();
		// dd($projectReferred);
		$pRArray = array();
		$parentArray = array();
		$childArray = array();
		$resultArray = array();
		$firstRefer = array();

		foreach( $projectReferred as $pR )
		{
			if( !in_array($pR->parent_name_id, $pRArray) )
			{
				$pRArray[] = $pR->parent_name_id;
				$parentArray[] = $pR->parent_name_id;
			}
			
			if( !in_array($pR->child_name_id, $pRArray) )
			{
				$pRArray[] = $pR->child_name_id;
				$childArray[] = $pR->child_name_id;
			}
		}
		// dd($pRArray);

		foreach( $salesTransactions as $index => $sT )
		{
			$firstRefer[$index][] = $sT->referredBy;
			$n = 1;

			do
			{
				if( $n == 1 )
				{
					$refer = ProjectReferredRelationship::with('parent', 'salesTransaction.referredBy')
												->where('child_name_id', '=', $sT->referred_by)
												->where('sales_transaction_id', '=', $sT->id)
												->first();
				}
				else
				{
					$refer = ProjectReferredRelationship::with('parent', 'salesTransaction')
												->where('child_name_id', '=', $tempParent)
												->where('sales_transaction_id', '=', $sT->id)
												->first();
				}
				
				$n++;

				if( !empty($refer) )
				{
					$resultArray[$index][] = $refer;
					$tempParent = $refer->parent_name_id;
				}
			}
			while(!empty($refer));
		}

		// dd($resultArray);
		return view('projectReferred.index')->with('firstRefer', $firstRefer)
											->with('resultArray', $resultArray);
	}

 	public function create()
 	{
 		$salesTransactions = SalesTransaction::all();
 		$personNames = User::all();

 		return view('projectReferred.create')->with('salesTransactions', $salesTransactions)
 											->with('personNames', $personNames);
 	}   

 	public function store(Request $request)
 	{
 		$validator = Validator::make($request->all(), [
	        'salesCode' => 'required|string',
	        'personName' => 'required|string|exists:users,id',
	        'parentName.*' => 'nullable|string|exists:users,id',
            'childName.*' => 'nullable|string|exists:users,id',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        try
        {
	        if( $request['parentName'][0] != NULL )
	        {
		        foreach( $request['parentName'] as $parentName )
		        {
			        $pRR = new ProjectReferredRelationship();

			        $pRR->sales_transaction_id = $request['salesCode'];
			        $pRR->parent_name_id = $parentName;
			        $pRR->child_name_id = $request['personName'];
			        
			        $pRR->save();
		        }
	        }

	        if( $request['childName'][0] != NULL )
	        {
		        foreach( $request['childName'] as $childName )
		        {
			        $pRR = new ProjectReferredRelationship();

			        $pRR->sales_transaction_id = $request['salesCode'];
			        $pRR->parent_name_id = $request['personName'];
			        $pRR->child_name_id = $childName;
			        
			        $pRR->save();
		        }
	        }
        }
        catch( \Exception $e )
        {
        	return redirect()->back()->with('unsuccessMessage', 'Failed to add referred !!!');
        }

        return redirect()->back()->with('successMessage', 'New Referred added successfully !!!');
 	}

 	public function editOverall()
 	{
 		$editParentChild = ProjectReferredRelationship::with('salesTransaction.company', 'parent', 'child')->get();

 		// dd($editParentChild);

 		return view('projectReferred.editOverall')->with('editParentChild', $editParentChild);
 	}

 	public function edit($id = '', $salesTransactionId = '')
 	{
 		$editParent = ProjectReferredRelationship::where('child_name_id', '=', $id)->where('sales_transaction_id', '=', $salesTransactionId)->get();

 		$editChild = ProjectReferredRelationship::where('parent_name_id', '=', $id)->where('sales_transaction_id', '=', $salesTransactionId)->get();

 		$sT = SalesTransaction::with('referredBy')->where('id', '=', $salesTransactionId)->first();

 		$salesTransactions = SalesTransaction::all();

 		$personNames = User::all();

 		$p = User::where('id', '=', $id)->first();

 		return view('projectReferred.edit')->with('editParent', $editParent)
 											->with('editChild', $editChild)
 											->with('salesTransactions', $salesTransactions)
 											->with('personNames', $personNames)
 											->with('p', $p)
 											->with('sT', $sT);
 		
 	}

 	public function update($id = '', $mainId = '', Request $request)
 	{
 		// dd($request);
 		$validator = Validator::make($request->all(), [
	        'salesCode' => 'required|string',
	        'personName' => 'required|string|exists:users,id',
	        'parentName.*' => 'nullable|string|exists:users,id',
            'childName.*' => 'nullable|string|exists:users,id',
	        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        
        	ProjectReferredRelationship::where('sales_transaction_id', '=', $id)->where('parent_name_id', '=', $mainId)->delete();
        	ProjectReferredRelationship::where('sales_transaction_id', '=', $id)->where('child_name_id', '=', $mainId)->delete();

	        if( $request['parentName'][0] != NULL )
	        {
		        foreach( $request['parentName'] as $parentName )
		        {
			        $pRR = new ProjectReferredRelationship();

			        $pRR->sales_transaction_id = $request['salesCode'];
			        $pRR->parent_name_id = $parentName;
			        $pRR->child_name_id = $request['personName'];
			        
			        $pRR->save();
		        }
	        }

	        if( $request['childName'][0] != NULL )
	        {
		        foreach( $request['childName'] as $childName )
		        {
			        $pRR = new ProjectReferredRelationship();

			        $pRR->sales_transaction_id = $request['salesCode'];
			        $pRR->parent_name_id = $request['personName'];
			        $pRR->child_name_id = $childName;
			        
			        $pRR->save();
		        }
	        }
        

        return redirect()->back()->with('successMessage', 'Referred updated successfully !!!');
 	}
}

<?php

namespace App\Http\Controllers\VisitCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VisitCategory\VisitCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class VisitCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listVisitCategory = VisitCategory::paginate(24);

        return view('visitCategory.list-visit-category')->with('listVisitCategory', $listVisitCategory);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visitCategory.add-visit-category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visitCategoryName' => 'required|string',
            'description' => 'required|string',
        ]);

        if( $validator->fails() )
        {
            return redirect()->back()
                            ->withInput()
                            ->withErrors($validator);
        }

        if( empty($request['visitCategoryId']) )
        {
            try
            {
                $visitCategory = new VisitCategory();

                $visitCategory->name = $request['visitCategoryName'];
                $visitCategory->description = $request['description'];
                $visitCategory->created_by = Auth::user()->id;

                $visitCategory->save();
            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to add new visit category !!!');
            }
            
            return redirect()->back()->with('successMessage', 'New Visit Category added successfully !!!');
        }
        else
        {
            try
            {
                $visitCategory = VisitCategory::where('id', '=', $request['visitCategoryId'])->first();

                $visitCategory->name = $request['visitCategoryName'];
                $visitCategory->description = $request['description'];
                $visitCategory->created_by = Auth::user()->id;

                $visitCategory->update();
            }
            catch( \Exception $e )
            {
                return redirect()->back()->with('unsuccessMessage', 'Failed to edit visit category !!!');
            }
            
            return redirect()->back()->with('successMessage', 'Visit Category edited successfully !!!');
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
        $editCategory = VisitCategory::where('id', '=', $id)->first();

        return view('visitCategory.add-visit-category')->with('editCategory', $editCategory);
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
        $deleteCategoryId = $request['category_id_delete'];

        try
        {
            $deleteVisitCategory = VisitCategory::where('id', '=', $deleteCategoryId)
                                                ->delete();
            
        }
        catch( \Exception $e )
        {
            return redirect()->back()->with('unsuccessMessage', 'Failed to delete visit category !!!');
        }

        return redirect()->back()->with('unsuccessMessage', 'Failed to delete visit category !!!');        

    }
}

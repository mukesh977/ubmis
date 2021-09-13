<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('tickets.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('tickets.categories.create');   
    }

    public function store(Request $request)
    {
        // setting default color to black
        $default_color = '#000000';
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        if($request->has('color'))
        {
            $default_color = $request->color;
        }
        $categories = new Categories;
        $categories->name = $request->name;
        $categories->color = $default_color;
        $categories->save();
        session()->flash('message', 'Category Added Successfully'); 
        return redirect('admin/categories ');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // dd('edit');
        $categories = Categories::findOrFail($id);
        return view('tickets/categories/edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $categories = Categories::findOrFail($id);
        $categories->name = $request->name;
        $categories->color = $request->color;
        $categories->save();
        session()->flash('message', 'Category Updated Successfully'); 
        return redirect('admin/categories ');
    }

    public function destroy($id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        session()->flash('message', 'Category Deleted Successfully'); 
        return redirect('admin/categories ');   
    }
}

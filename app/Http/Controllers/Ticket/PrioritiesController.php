<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Priorities;

class PrioritiesController extends Controller
{
    public function index()
    {
        $priorities = Priorities::all();
        return view('tickets.priorities.index', compact('priorities'));
    }


    public function create()
    {
        return view('tickets.priorities.create');   
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
        $priorities = new Priorities;
        $priorities->name = $request->name;
        $priorities->color = $default_color;
        $priorities->save();
        session()->flash('message', 'Priority Added Successfully'); 
        return redirect('admin/priorities ');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // dd('edit');
        $priorities = Priorities::findOrFail($id);
        return view('tickets/priorities/edit', compact('priorities'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $priorities = Priorities::findOrFail($id);
        $priorities->name = $request->name;
        $priorities->color = $request->color;
        $priorities->save();
        session()->flash('message', 'Priorities Updated Successfully'); 
        return redirect('admin/priorities ');
    }

    public function destroy($id)
    {
        $priorities = Priorities::findOrFail($id);
        $priorities->delete();
        session()->flash('message', 'Priorities Deleted Successfully'); 
        return redirect('admin/priorities ');   
    }
}

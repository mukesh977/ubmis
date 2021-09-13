<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket\Status;
class StatusController extends Controller
{
    public function index()
    {
        $status = Status::all();
        return view('tickets.status.index', compact('status'));
    }

    
    public function create()
    {
        // return view('Tickets.status.create');   
    }

    public function store(Request $request)
    {
        // setting default color to black
        // $default_color = '#000000';
        // $this->validate($request, [
        //     'name' => 'required|string',
        // ]);
        // if($request->has('color'))
        // {
        //     $default_color = $request->color;
        // }
        // $status = new Status;
        // $status->name = $request->name;
        // $status->color = $default_color;
        // $status->save();
        // session()->flash('message', 'Status Added Successfully'); 
        // return redirect('admin/status ');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // dd('edit');
        $status = Status::findOrFail($id);
        return view('tickets/status/edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $status = Status::findOrFail($id);
        $status->name = $request->name;
        $status->color = $request->color;
        $status->save();
        session()->flash('message', 'Status Updated Successfully'); 
        return redirect('admin/status ');
    }

    public function destroy($id)
    {
        // $status = Status::findOrFail($id);
        // $status->delete();
        // session()->flash('message', 'Status Deleted Successfully'); 
        // return redirect('admin/status ');   
    }
}

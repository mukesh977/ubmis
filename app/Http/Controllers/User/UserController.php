<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Access\Role\Role;
use Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = (new User())->getUsersAccToRole();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $roles = (new Role())->getRoles();

        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
    	$inputs =  $request->all();
	    $inputs['password'] = bcrypt($request->password);
	    $user = User::create($inputs);

	    $user->roles()->attach($request->role);

	    return redirect()->route('user.index')->with('success', 'User created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles', 'roles.permissions')->where('id', $id)->first();

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $roles = (new Role())->getRoles();

	    $user = User::with('roles', 'roles.permissions')->where('id', $id)->first();

	    return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
	    $inputs =  $request->all();
	    $inputs['password'] = bcrypt($request->password);
	    $user = User::find($id);
	    $user->roles()->detach();
	    $user->update($inputs);
	    $user->roles()->attach($request->role);

	    return redirect()->route('user.index')->with('success', 'User profile updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('user.index')->with('error', 'Deleted Successfully.');
    }
}

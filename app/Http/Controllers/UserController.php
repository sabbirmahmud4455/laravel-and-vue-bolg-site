<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $role= Role::all();
        $users= User::with(["role"])->orderBy('id', 'desc')->get();
        return response()->json( ['users'=>$users, 'roles'=> $role]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'full_name'=>'required|max:200',
            'email'=>'required|email|unique:users,email|max:200',
            'role'=>'required|max:200',
            'password'=>'required',
        ]);
        
        User::insert([
            'full_name'=> $request->full_name,
            'email'=> $request->email,
            'role_id'=> $request->role,
            'password'=> bcrypt($request->password),
            'status'=> 0,
            'created_at'=> Carbon::now()
        ]);
        return response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json('not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name'=> 'required',
            'role'=> 'required',
            'email'=>'required|email|unique:users,full_name,'.$user->id,
        ]);
        if ($request->password=='') {
            $user->update([
                'full_name'=> $request->full_name,
                'email'=> $request->email,
                'updated_at'=> Carbon::now()
            ]);
        } else {
            $user->update([
                'full_name'=> $request->full_name,
                'email'=> $request->email,
                'user_type'=> $request->role,
                'password'=> bcrypt($request->password),
                'updated_at'=> Carbon::now()
            ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User Delete Successfully');
    }
}

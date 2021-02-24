<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles= Role::orderBy('id', 'desc')->get();
        return response()->json($roles);
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
            'role_name'=>'required'
        ]);
        
        Role::insert([
            'role_name'=> $request->role_name,
            'permission'=> $request->permission,
            'created_at'=> Carbon::now()
        ]);
        return response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name'=>'required'
        ]);
        $role->update([
            'role_name'=> $request->role_name,
            'updated_at'=> Carbon::now()
        ]);
       
        return response()->json('ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json('User Delete Successfully');
    }

    // role_assigns
    public function role_assigns(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'permissions_data'=>'required'
        ]); 
        Role::find($request->id)->update([
            'permission'=> $request->permissions_data
        ]);
        return response()->json('$request->permission_data');
    }
}


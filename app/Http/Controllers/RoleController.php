<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Ability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_roles');

        $roles = Role::latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('add_role');

        $abilites = Ability::get();
        return view('admin.roles.create',compact('abilites'));
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
            'name'=>'required'
        ]);

        $role = Role::create([
            'name'=>$request->name
        ]);

        $role->abilities()->attach($request->ability);

        return redirect()->route('admin.roles.index')->with('msg',__('admin.Role has been added successfully'))->with('type','success');
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
        Gate::authorize('edit_role');

        $role = Role::where('id',$id)->first();
        $abilites = Ability::get();
        return view('admin.roles.edit',compact('abilites','role'));
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
        $request->validate([
            'name'=>'required'
        ]);
        $role = Role::where('id',$id)->first();

        $role->update([
            'name'=>$request->name
        ]);

        $role->abilities()->sync($request->ability);

        return redirect()->route('admin.roles.index')->with('msg',__('admin.Role has been updated successfully'))->with('type','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('delete_role');

        $role= Role::where('id',$id)->first();
        $role->destroy($id);
        return $id;

    }
}

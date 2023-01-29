<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\University;
use Illuminate\Http\Request;

class SpecializationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specializations = Specialization::with('university')->latest('id')->paginate(env('PAGINATION_COUNT'));
        $universities = University::all();
        return view('admin.specializations.index',compact('specializations', 'universities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $universities = University::get();
        return view('admin.specializations.create', compact('universities'));
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
            'name' => 'required|min:2',
            'university_id'=>'required'
        ]);

        Specialization::create([
            'name' => $request->name ,
            'university_id' => $request->university_id,
        ]);

        return redirect()->route('admin.specializations.index')
        ->with('msg', 'Specialization has been addedd successfully')
        ->with('type', 'success');

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
    public function edit(Specialization $specialization)
    {
        $universities = University::all();
        return view('admin.specializations.edit', compact('specialization','universities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Specialization $specialization)
    {

        
        $request->validate([
            'name' => 'required',
            'university_id' => 'required',
        ]);

        // dd($request->all());
        $specialization->update([
            'name' => $request->name,
            'university_id' => $request->university_id,

        ]);

        return redirect()->route('admin.specializations.index')
        ->with('msg', 'Specialization has been updated successfully')
        ->with('type', 'success');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specializations= Specialization::findOrFail($id);
        $specializations->delete();
        return $id;
    }
}

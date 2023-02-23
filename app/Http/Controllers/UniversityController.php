<?php

namespace App\Http\Controllers;

use App\Http\Requests\UniversityRequest;
use App\Models\Specialization;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = University::latest('id')->paginate(env('PAGINATION_COUNT '));

        return view('admin.universities.index' , compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.universities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UniversityRequest $request)
    {
        $universities = University::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.universities.index')->with('msg', __('admin.University has been added successfully'))->with('type', 'success');
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UniversityRequest $request, $id)
    {
        $universities= University::findOrFail($id);


        $universities->name = $request->name;
        $universities->email = $request->email;
        $universities->phone = $request->phone;
        $universities->address = $request->address;


        $universities->save();

        return $universities;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $universities= University::findOrFail($id);
        $universities->delete();
        return $id;
    }


    /**
     * return specialization based on university
     *
     */
    public function get_specialization($id)
    {
        $specializations = Specialization::where('university_id', $id)->pluck("name", 'id');
        return json_encode($specializations);
    }
}

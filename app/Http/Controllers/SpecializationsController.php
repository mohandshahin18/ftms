<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;

class SpecializationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specializations = Specialization::latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.specializations.index',compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specializations.create');
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
        ]);

        $slug = Str::slug($request->name);
        $slugCount = Specialization::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $count;
        }

        Specialization::create([
            'name' => $request->name ,
<<<<<<< HEAD
=======
            'university_id' => $request->university_id,
            'slug' => $slug,
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d
        ]);

        return redirect()->route('admin.specializations.index')
        ->with('msg', __('admin.Specialization has been added successfully'))
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
    public function edit($slug)
    {
        $universities = University::all();
<<<<<<< HEAD
        return view('admin.specializations.edit', compact('specialization'));
=======
        $specialization = Specialization::whereSlug($slug)->first();
        return view('admin.specializations.edit', compact('specialization','universities'));
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$slug)
    {

        $specialization = Specialization::whereSlug($slug)->first();

        $request->validate([
            'name' => 'required',
        ]);


        $slug = Str::slug($request->name);
        $slugCount = Specialization::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $count;
        }


        $specialization->update([
            'name' => $request->name,
<<<<<<< HEAD
=======
            'university_id' => $request->university_id,
            'slug' => $slug
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d

        ]);

        return redirect()->route('admin.specializations.index')
        ->with('msg', __('admin.Specialization has been updated successfully'))
        ->with('type', 'success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $specialization = Specialization::whereSlug($slug)->first();
        $specialization->destroy($specialization->id);
        return $slug;
    }
}

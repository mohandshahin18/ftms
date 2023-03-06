<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
use Symfony\Component\CssSelector\Node\Specificity;
=======
use App\Http\Requests\UniversityRequest;
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d

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
        $specializations = Specialization::all();
        return view('admin.universities.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UniversityRequest $request)
    {
<<<<<<< HEAD
        $university = University::create([
=======
        $slug = Str::slug($request->name);
        $slugCount = University::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }

        $universities = University::create([
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'slug' =>$slug
        ]);

<<<<<<< HEAD
        $university->specializations()->sync($request->specialization_id);

        return redirect()->route('admin.universities.index')->with('msg', __('admin.University has been addedd successfully'))->with('type', 'success');
=======
        return redirect()->route('admin.universities.index')->with('msg', __('admin.University has been added successfully'))->with('type', 'success');
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d
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
    public function edit(University $university)
    {
        $attached_specializations = $university->specializations()->get()->map(function($specialization) {
            return $specialization->id;
        })->toArray();

        $specializations = Specialization::latest()->get();
        return view('admin.universities.edit', compact('university', 'attached_specializations', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UniversityRequest $request, $slug)
    {
<<<<<<< HEAD
        $university= University::findOrFail($id);
=======
        $universities= University::whereSlug($slug)->first();

        $slug = Str::slug($request->name);
        $slugCount = University::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
            $universities->slug = $slug;
        }
>>>>>>> 25f7bd83733fdf50d4799eeb51ae766e9177ec6d

        $university->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $university->specializations()->sync($request->specialization_id);

        return redirect()->route('admin.universities.index')->with('msg', __('admin.University has been updated successfully'))->with('type', 'success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $universities = University::whereSlug($slug)->first();
        $universities->delete();
        return $slug;
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

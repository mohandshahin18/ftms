<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Node\Specificity;
use App\Http\Requests\UniversityRequest;

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

        $slug = Str::slug($request->name);
        $slugCount = University::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }

        $universities = University::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'slug' =>$slug
        ]);

        $universities->specializations()->sync($request->specialization_id);

        return redirect()->route('admin.universities.index')->with('msg', __('admin.University has been addedd successfully'))->with('type', 'success');
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
        $universities= University::whereSlug($slug)->first();
        $slug = Str::slug($request->name);
        $slugCount = University::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;


        if($slugCount > 1){
            $slug = $slug . '-' . $count;
            $universities->slug = $slug;
        }

        $universities->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $universities->specializations()->sync($request->specialization_id);

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
        $university = University::findOrFail($id);
        $specializations = $university->specializations()->get()->map(function($specialization) {
            return [
                'id' => $specialization->id,
                'name' => $specialization->name
            ];
        });
        return json_encode($specializations);
    }
}

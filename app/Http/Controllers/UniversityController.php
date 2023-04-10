<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UniversityRequest;
use Symfony\Component\CssSelector\Node\Specificity;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_universities');

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
        Gate::authorize('add_university');

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
        Gate::authorize('edit_university');

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

        $email = $universities->email;
        if($request->email != $email){
            $exisitStudent_id = University::where('email',$request->email)->get();
            if(is_null($exisitStudent_id)){

              $email = $request->email;

        }else{
            return redirect()->back()->with('customError',__('admin.Email is already taken'))->with('type','danger');
        }
        }

        $phone = $universities->phone;
            if ($request->phone != $phone) {
                $exisitPhone = University::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {
                    $phone = $request->phone;
                } else {
                    return redirect()->back()->with('customError',__('admin.The mobile number is already in use'))->with('type','danger');
                }
            }


        $universities->update([
            'name' => $request->name,
            'email' => $email,
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
        Gate::authorize('delete_university');

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

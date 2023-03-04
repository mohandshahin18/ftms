<?php

namespace App\Http\Controllers;

use App\Models\Subsicribe;
use Illuminate\Http\Request;

class SubsicribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribes = Subsicribe::latest('id')->paginate(env('PAGINATION_COUNT'));

        return view('admin.subscribes.index' , compact('subscribes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscribes.create');

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
            'university_id_st' =>'required'
        ]);

        Subsicribe::create([
            'university_id' => $request->university_id_st,
        ]);

        return redirect()->route('admin.subscribes.index')->with('msg', __('admin.University has been added successfully'))->with('type', 'success');

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
        //
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
            'university_id_st' =>'required'
        ]);

        $subscribes= Subsicribe::where('id',$id)->first();



        $subscribes->university_id = $request->university_id_st;



        $subscribes->save();

        return $subscribes;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function selectUniversity_id()
     {
         return view('auth.university_id');
     }

     /**
      * ensure if university id is already exsitis in database.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

     public function subsicribeId(Request $request)
     {
         $request->validate([
             'university_id_st' => 'required',
         ]);
         $subsicribes = Subsicribe::get();

         foreach($subsicribes as $subsicribe){
             if($subsicribe->university_id == $request->university_id_st){
                 return route('student.register-view',$request->university_id_st);
             }else{
                 return response()->json(['title'=>__('admin.The entered university id is not registered with us')],400);
             }

         }

     }
}

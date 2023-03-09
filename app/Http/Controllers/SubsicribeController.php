<?php

namespace App\Http\Controllers;

use App\Imports\ImportUniversityId;
use App\Models\Subsicribe;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            'name' =>'required',
            'university_id_st' =>'required|unique:subsicribes,university_id'
        ]);

        Subsicribe::create([
            'name' => $request->name,
            'university_id' => $request->university_id_st,
        ]);

        return redirect()->route('admin.subscribes.index')->with('msg', __('admin.University has been added successfully'))->with('type', 'success');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('admin.subscribes.importUniversityId');

    }

    /**
     * import data from exale.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $file = $request->file('file');

        Excel::import(new ImportUniversityId, $file);

        return redirect()->route('admin.subscribes.index')->with('msg', __('admin.File imported successfully.'))->with('type','success');

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
            'name'=>'required',
            'university_id_st' =>'required'
        ]);

        $subscribes= Subsicribe::where('id',$id)->first();
        


        $subscribes->name = $request->name;
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
        $subscribes= Subsicribe::where('id',$id)->first();

        $subscribes->destroy($id);
        return $id;
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
         $subsicribe = Subsicribe::where('university_id',$request->university_id_st)->first();

            if($subsicribe){
                 return response()->json([route('student.register-view',$request->university_id_st)],200);
             }else{
                 return response()->json(['title'=>__('admin.The entered university id is not registered with us')],400);
             }
     }
}

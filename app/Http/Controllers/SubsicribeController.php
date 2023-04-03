<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subsicribe;
use App\Models\University;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportUniversityId;
use Illuminate\Support\Facades\Gate;
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
        Gate::authorize('all_university_ids');

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
        Gate::authorize('add_university_id');

        $specializations = Specialization::get();
        $universities = University::get();
        return view('admin.subscribes.create',compact('specializations','universities'));

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
            'university_id_st' =>'required|unique:subsicribes,university_id',
            'university_id' =>'required',
            'specialization_id' =>'required'
        ]);

        Subsicribe::create([
            'name' => $request->name,
            'student_id' => $request->university_id_st,
            'specialization_id' => $request->specialization_id,
            'university_id' => $request->university_id,
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
        Gate::authorize('import_university_id');

        return view('admin.subscribes.importUniversityId');

    }

    /**
     * import data from exale.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:xlsx'
        ]);
        $file = $request->file('file');

        // Get an array of university numbers from the Excel file
            $universityNumbers = Excel::toArray([], $file)[0];
            $universityNumbers = array_column($universityNumbers, 1);
            // Get an array of university numbers that already exist in the database
            $existingUniversityNumbers = DB::table('students')->pluck('student_id')->toArray();

            // Find the university numbers that already exist in the database
            $duplicateUniversityNumbers = array_intersect($universityNumbers, $existingUniversityNumbers);
             $newValue = json_encode($duplicateUniversityNumbers);
            if(count($duplicateUniversityNumbers) == 1){
                $title = __('admin.The following entered university id already exists');
            }else{
                $title = __('admin.The following entered university ids already exist');
            }

            if(count($duplicateUniversityNumbers) > 0) {

                return redirect()->back()->with('error', " $title  => $newValue")->with('type','danger');
            }
            else {
                // Import the data from the Excel file
                Excel::import(new ImportUniversityId, $file);
            }



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
        Gate::authorize('edit_university_id');

        $subsicribe = Subsicribe::where('id',$id)->first();
        $specializations = Specialization::get();
        $universities = University::get();
        return view('admin.subscribes.edit',compact('subsicribe','specializations','universities'));
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
        $subsicribe = Subsicribe::where('id', $id)->first();
        $request->validate([
            'name'=>'required',
            'university_id_st' =>'required',
            'university_id' =>'required',
            'specialization_id' =>'required'
        ]);


        $subsicribe->update([
            'name'=>  $request->name ,
            'student_id' => $request->university_id_st ,
            'university_id'=> $request->university_id,
            'specialization_id'=> $request->specialization_id ,
        ]);
        return redirect()->route('admin.subscribes.index')->with('msg', __('admin.University ID has been updated successfully'))->with('type', 'success');



        // return $subscribes;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('delete_university_id');

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

         $student = Student::where('student_id',$request->university_id_st)->first();

        if(!$student){
            $subsicribe = Subsicribe::where('student_id',$request->university_id_st)->first();

            if($subsicribe){
                 return response()->json([route('student.register-view',$request->university_id_st)],200);
             }else{
                 return response()->json(['title'=>__('admin.The entered university id is not registered with us')],400);
             }
        }else{
            return response()->json(['title'=>__('admin.The entered university already exists')],400);
        }
     }
}

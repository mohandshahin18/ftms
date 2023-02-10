<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Trainer;
use App\Models\Category;
use App\Rules\TextLength;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\University;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    /**
     * Show the application selection.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.selection');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {

        return view('admin.home');
    }

     /**
     * Show the application setting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        return view('admin.settings');
    }


    public function settings_store(Request $request)
    {
        $rule = 'required';

        if(settings()->get('logo') != '') {
            $rule = 'nullable';
        }

        $request->validate([
            'footer_text' => ['required' , new TextLength()],
            'email' => ['required' , 'email'] ,
            'copy_right' => ['required'] ,
            'distributed_by' => ['required'] ,
            'logo' => [$rule,'mimes:png,jpg,jpeg,svg,jfif','max:2048'] ,
        ]);

        $logo = settings()->get('logo');
        if($request->has('logo')){
            $logo = $request->file('logo')->store('uploads/settings/logo' , 'custom');
            settings()->set('logo' , $logo);
        }

        settings()->set('footer_text' , $request->footer_text);
        settings()->set('email' , $request->email);
        settings()->set('copy_right' , $request->copy_right);
        settings()->set('distributed_by' , $request->distributed_by);


        settings()->save();
        return redirect()->back()->with('msg' ,'Settings Updated succssfully') ->with('type' , 'success');

    }


        /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        if(Auth::guard('teacher')->check()){
            $teacher = Teacher::with('university')->where('id',  Auth::guard()->user()->id)->first();
            $university = $teacher->university->name;
            $specializations = Specialization::where('university_id', $teacher->university_id)->get();
            return view('admin.profile' , compact('university','specializations'));

        }elseif(Auth::guard('trainer')->check()){
            $trainer = Trainer::with('company')->where('id',  Auth::guard()->user()->id)->first();
            $company = $trainer->company->name;
            $companies = Company::with('categories')->where('id', $trainer->company->id)->first();
            $categories = $companies->categories;
            return view('admin.profile' , compact('company', 'categories'));

        }elseif(Auth::guard('company')->check()){
            $categories = Category::get();
            $company = Company::with('students')->findOrFail(Auth::user()->id);
            $attached_categories = $company->categories()->get()->map(function($category) {
                return $category->id;
            })->toArray();
            return view('admin.profile' , compact('categories', 'attached_categories','company'));
        }
        else{
            return view('admin.profile' );
        }

    }


    public function profile_edit(Request $request , $id)
    {


      if(Auth::guard('admin')->check() ){
        $admin =Admin::findOrFail($id);
        $path = $admin->image;
        if($request->file('image')) {
            File::delete(public_path($admin->image));
            $path = $request->file('image')->store('/uploads/admin', 'custom');
        }


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'nullable'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $path,
        ]);

        return json_encode(array("email"=>$admin->email, "name"=>$admin->name));

      }elseif(Auth::guard('teacher')->check() ){

        $teacher =Teacher::findOrFail($id);
        $path = $teacher->image;
        if($request->file('image')) {
            File::delete(public_path($teacher->image));
            $path = $request->file('image')->store('/uploads/teacher', 'custom');
        }



        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'nullable',
            'specialization_id' => 'required'
        ]);


        if(!($request->specialization_id == $teacher->specialization_id)) {
            $students = Student::where('university_id', $teacher->university_id)->where('specialization_id', $teacher->specialization_id)->get();


            foreach($students as $student){
                $student->update([
                    'teacher_id' => null
                ]);
            }

        }

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization_id' => $request->specialization_id,
            'image' => $path,
        ]);


        $students = Student::where('university_id', $teacher->university_id)->where('specialization_id', $request->specialization_id)->get();

        if($students) {
            foreach($students as $student){
                $student->update([
                    'teacher_id' => $teacher->id
                ]);
            }
        }


        return json_encode(array("email"=>$teacher->email, "name"=>$teacher->name));

      }elseif(Auth::guard('trainer')->check() ){
            $trainer =Trainer::findOrFail($id);
            $path = $trainer->image;
            if($request->file('image')) {
                File::delete(public_path($trainer->image));
                $path = $request->file('image')->store('/uploads/trainer', 'custom');
            }


            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable',
                'category_id' => 'required'
            ]);

            $trainer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $path,
                'category_id' => $request->category_id
            ]);

            return json_encode(array("email"=>$trainer->email, "name"=>$trainer->name));

      }elseif(Auth::guard('company')->check() ){

        $company =Company::findOrFail($id);
        // dd($request->file('image'))
        $path = $company->image;
        if($request->file('image')) {
            File::delete(public_path($company->image));
            $path = $request->file('image')->store('/uploads/company', 'custom');
        }


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'image' => 'nullable',
            'category_id' => 'required',
            'address' => 'required',
            'description' => ['required',new TextLength()],
        ]);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $path,
            'address' => $request->address,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        $company->categories()->sync( $request->category_id);

        return json_encode(array("email"=>$company->email, "name"=>$company->name));


      }
    }



    public function editPassword($type)
    {
        if($type == 'teacher' || $type == 'trainer'|| $type == 'company' || $type == 'admin'){
            return view('admin.resetPassword' , compact('type'));
        }elseif($type == 'student'){
            return view('student.resetPassword' );
        }else{
            return abort(404);

        }
    }

    public function updatePassword(Request $request ){


        $request->validate([
        'current_password'=>'required',
        'new_password'=>'required|string|min:6|max:25|confirmed',
        'new_password_confirmation'=>'required'
        ], [
        'current_password.required'=> "The current password field is required.",
        ]);



            $student = Auth::guard()->user();

            //Match The current Password
            if(!Hash::check($request->current_password, $student->password)){
                return redirect()->back()->with('msg' , "The Current Password Doesn't match!")->with('type' , 'danger') ;
            }
            elseif (Hash::check($request->current_password, $student->password) && Hash::check($request->new_password, $student->password)) {
                return redirect()->back()->with('msg' , 'The new password can not be the current password!')->with('type' , 'danger') ;
            } //new password can not be the current password!
            else{
                $student->password = Hash::make($request->new_password);
                $student->save();
                return redirect()->back()->with('msg' , 'Updated Password is successfully')->with('type','success') ;
            }
        }




}

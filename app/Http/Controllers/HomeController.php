<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Company;
use App\Models\Teacher;
use App\Rules\TextLength;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Models\Trainer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
            return view('admin.profile' , compact('company'));
        }elseif(Auth::guard('company')->check()){
            $categories = Category::get();
            return view('admin.profile' , compact('categories'));
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
        if($request->image) {
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

        return redirect()->route('admin.profile')->with('msg', 'Profile has been updated successfully')->with('type', 'success');

      }elseif(Auth::guard('teacher')->check() ){

        $teacher =Teacher::findOrFail($id);
        $path = $teacher->image;
        if($request->image) {
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

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'specialization_id' => $request->specialization_id,
            'image' => $path,
        ]);

        return redirect()->route('admin.profile')->with('msg', 'Profile has been updated successfully')->with('type', 'success');
      }elseif(Auth::guard('trainer')->check() ){
            $trainer =Trainer::findOrFail($id);
            $path = $trainer->image;
            if($request->image) {
                File::delete(public_path($trainer->image));
                $path = $request->file('image')->store('/uploads/trainer', 'custom');
            }


            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable'
            ]);

            $trainer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $path,
            ]);

            return redirect()->route('admin.profile')->with('msg', 'Profile has been updated successfully')->with('type', 'success');
      }elseif(Auth::guard('company')->check() ){

        $company =Company::findOrFail($id);
        $path = $company->image;
        if($request->image) {
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
            'category_id' => $request->category_id,
            'address' => $request->address,
            'description' => $request->description,


        ]);

        return redirect()->route('admin.profile')->with('msg', 'Profile has been updated successfully')->with('type', 'success');


      }
    }
}

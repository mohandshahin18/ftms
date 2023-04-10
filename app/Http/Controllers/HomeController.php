<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Admin;
use App\Models\Advert;
use App\Models\Company;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Trainer;
use App\Models\Category;
use App\Mail\ContactMail;
use App\Mail\verifyEmail;
use App\Rules\TextLength;
use App\Models\University;
use App\Rules\TwoSyllables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SettingWebsite;
use App\Models\Specialization;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $students = Student::count();
        $companies = Company::count();
        $specializations = Specialization::count();
        $categories = Category::count();
        $sub_title = '';
        $adverts = '';
        $lastAdvert = '';

        if (!Auth::guard('admin')->check()) {
            $lastAdvert = Auth::user()->adverts()->latest('id')->limit(1)->first();
            $students = Auth::user()->students()->count();
            $adverts = Auth::user()->adverts()->count();
        }

        return view('admin.home', compact('students', 'companies', 'specializations', 'categories', 'lastAdvert', 'adverts'));
    }

    /**
     * Show the application setting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        $team_members = SettingWebsite::latest('id')->get();
        return view('admin.settings', compact('team_members'));
    }


    public function settings_store(Request $request)
    {
        $rule = 'required';

        if (settings()->get('logo') != '') {
            $rule = 'nullable';
        }

        $request->validate([
            'footer_text' => ['required', new TextLength()],
            'email' => ['required', 'email'],
            'copy_right' => ['required'],
            'distributed_by' => ['required'],
            'logo' => [$rule, 'mimes:png,jpg,jpeg,svg,jfif', 'max:2048'],
            'darkLogo' => [$rule, 'mimes:png,jpg,jpeg,svg,jfif', 'max:2048'],
        ]);



        $logo = settings()->get('logo');

        if ($request->has('logo')) {
            $logo = $request->file('logo')->store('uploads/settings/logo', 'custom');
            settings()->set('logo', $logo);
        }

        $darkLogo = settings()->get('darkLogo');

        if ($request->has('darkLogo')) {
            $darkLogo = $request->file('darkLogo')->store('uploads/settings/logo', 'custom');
            settings()->set('darkLogo', $darkLogo);
        }

        settings()->set('footer_text', $request->footer_text);
        settings()->set('email', $request->email);
        settings()->set('copy_right', $request->copy_right);
        settings()->set('distributed_by', $request->distributed_by);


        settings()->save();
        return response()->json([$logo]);
    }

    public function settings_website(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'specialization' => ['required'],
            'linkedin' => ['required'],
            'facebook' => ['required'],
            'github' => ['required'],
            'image' => ['required', 'mimes:png,jpg,jpeg,svg,jfif', 'max:2048'],
        ]);


        $path = $request->file('image')->store('/uploads/settings/team', 'custom');

        $member = SettingWebsite::create([
            'name' => $request->name,
            'specialization' => $request->specialization,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'github' => $request->github,
            'image' => $path,
        ]);

        return $member;
    }

    public function editMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'name' => ['required'],
            'specialization' => ['required'],
            'linkedin' => ['required'],
            'facebook' => ['required'],
            'github' => ['required'],
        ]);
        $members = SettingWebsite::where('id', $id)->first();

        $path = $members->image;

        if ($request->image) {
            File::delete(public_path($members->image));

            $path = $request->file('image')->store('/uploads/settings/team', 'custom');
        }

        $members->name = $request->name;
        $members->specialization = $request->specialization;
        $members->linkedin = $request->linkedin;
        $members->github = $request->github;
        $members->facebook = $request->facebook;
        $members->image = $path;


        $members->save();

        return $members;
    }


    public function deleteMember($id)
    {
        $member = SettingWebsite::where('id', $id)->first();
        $path = public_path($member->image);

        if ($path) {
            try {
                File::delete($path);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $member->delete();
        return $id;
    }
    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        if (Auth::guard('teacher')->check()) {
            $teacher = Teacher::with('university')->where('id',  Auth::guard()->user()->id)->first();
            $university = $teacher->university->name;
            $specializations = Specialization::get();
            return view('admin.profile', compact('university', 'specializations'));
        } elseif (Auth::guard('trainer')->check()) {
            $trainer = Trainer::with('company')->where('id',  Auth::guard()->user()->id)->first();
            $company = $trainer->company->name;
            $companies = Company::with('categories')->where('id', $trainer->company->id)->first();
            $categories = $companies->categories;
            return view('admin.profile', compact('company', 'categories'));
        } elseif (Auth::guard('company')->check()) {
            $categories = Category::get();
            $company = Company::with('students')->findOrFail(Auth::user()->id);
            $attached_categories = $company->categories()->get()->map(function ($category) {
                return $category->id;
            })->toArray();
            return view('admin.profile', compact('categories', 'attached_categories', 'company'));
        } else {
            return view('admin.profile');
        }
    }


    public function profile_edit(Request $request, $id)
    {


        if (Auth::guard('admin')->check()) {
            $admin = Admin::findOrFail($id);
            $path = $admin->image;
            if ($request->file('image')) {
                File::delete(public_path($admin->image));
                $path = $request->file('image')->store('/uploads/admin', 'custom');
            }


            $request->validate([
                'name' => ['required', new TwoSyllables()],
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable|max:4096'
            ]);
            $is_email_verified = 1;
            if ($request->email != Auth::user()->email) {
                $exisitEmail = Admin::where('email', $request->email)->get();

                if (is_null($exisitEmail)) {
                    $actor = 'admin';
                    $is_email_verified = 0;

                    Mail::send('emails.virefyEmailAdmins', ['actor' => $actor, 'slug' => $admin->slug], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Email Verification Mail');
                    });
                } else {
                    return response()->json(['email' => __('admin.The email is already in use'), 'filed' => 'email'], 400);
                }
            }



            $phone = Auth::user()->phone;
            if ($request->phone != $phone) {
                $exisitPhone = Admin::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {

                    $phone = $request->phone;
                } else {
                    return response()->json(['phone' => __('admin.The mobile number is already in use'), 'filed' => 'phone'], 400);
                }
            }

            $admin->update([
                'is_email_verified' => $is_email_verified,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $phone,
                'image' => $path,
            ]);

            return json_encode(array("email" => $admin->email, "name" => $admin->name, "image" => $admin->image));
        } elseif (Auth::guard('teacher')->check()) {

            $teacher = Teacher::findOrFail($id);
            $path = $teacher->image;
            if ($request->file('image')) {
                File::delete(public_path($teacher->image));
                $path = $request->file('image')->store('/uploads/teacher', 'custom');
            }



            $request->validate([
                'name' => ['required', new TwoSyllables()],
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable',
                'specialization_id' => 'required'
            ]);


            if (!($request->specialization_id == $teacher->specialization_id)) {
                $students = Student::where('university_id', $teacher->university_id)->where('specialization_id', $teacher->specialization_id)->get();


                foreach ($students as $student) {
                    $student->update([
                        'teacher_id' => null
                    ]);
                }
            }
            $is_email_verified = 1;
            if ($request->email != Auth::user()->email) {
                $exisitEmail = Teacher::where('email', $request->email)->get();

                if (is_null($exisitEmail)) {

                    $actor = 'teacher';
                    $is_email_verified = 0;

                    Mail::send('emails.virefyEmailAdmins', ['actor' => $actor, 'slug' => $teacher->slug], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Email Verification Mail');
                    });
                } else {
                    return response()->json(['email' => __('admin.The email is already in use'), 'filed' => 'email'], 400);
                }
            }
            $phone = Auth::user()->phone;
            if ($request->phone != $phone) {
                $exisitPhone = Teacher::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {

                    $phone = $request->phone;
                } else {
                    return response()->json(['phone' => __('admin.The mobile number is already in use'), 'filed' => 'phone'], 400);
                }
            }

            $teacher->update([
                'is_email_verified' => $is_email_verified,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $phone,
                'specialization_id' => $request->specialization_id,
                'image' => $path,
            ]);


            $students = Student::where('university_id', $teacher->university_id)->where('specialization_id', $request->specialization_id)->get();

            if ($students) {
                foreach ($students as $student) {
                    $student->update([
                        'teacher_id' => $teacher->id
                    ]);
                }
            }


            return json_encode(array("email" => $teacher->email, "name" => $teacher->name, "image" => $teacher->image));
        } elseif (Auth::guard('trainer')->check()) {
            $trainer = Trainer::findOrFail($id);
            $path = $trainer->image;
            if ($request->file('image')) {
                File::delete(public_path($trainer->image));
                $path = $request->file('image')->store('/uploads/trainer', 'custom');
            }


            $request->validate([
                'name' => ['required', new TwoSyllables()],
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable',
                'category_id' => 'required'
            ]);
            $is_email_verified = 1;
            if ($request->email != Auth::user()->email) {
                $exisitEmail = Trainer::where('email', $request->email)->get();

                if (is_null($exisitEmail)) {

                    $actor = 'trainer';
                    $is_email_verified = 0;

                    Mail::send('emails.virefyEmailAdmins', ['actor' => $actor, 'slug' => $trainer->slug], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Email Verification Mail');
                    });
                } else {
                    return response()->json(['email' => __('admin.The email is already in use'), 'filed' => 'email'], 400);
                }
            }

            $phone = Auth::user()->phone;
            if ($request->phone != $phone) {
                $exisitPhone = Trainer::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {

                    $phone = $request->phone;
                } else {
                    return response()->json(['phone' => __('admin.The mobile number is already in use'), 'filed' => 'phone'], 400);
                }
            }
            $trainer->update([
                'is_email_verified' => $is_email_verified,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $phone,
                'image' => $path,
                'category_id' => $request->category_id
            ]);


            return json_encode(array("email" => $trainer->email, "name" => $trainer->name, "image" => $trainer->image));
        } elseif (Auth::guard('company')->check()) {

            $company = Company::findOrFail($id);
            $path = $company->image;
            if ($request->file('image')) {
                File::delete(public_path($company->image));
                $path = $request->file('image')->store('/uploads/company', 'custom');
            }

            $request->validate([
                'name' => ['required', new TwoSyllables()],
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'nullable',
                'category_id' => 'required',
                'address' => 'required',
                'description' => ['required', new TextLength()],
            ]);
            $is_email_verified = 1;
            if ($request->email != Auth::user()->email) {
                $exisitEmail = Company::where('email', $request->email)->get();

                if (is_null($exisitEmail)) {

                    $actor = 'company';

                    $is_email_verified = 0;

                    Mail::send('emails.virefyEmailAdmins', ['actor' => $actor, 'slug' => $company->slug], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Email Verification Mail');
                    });
                } else {
                    return response()->json(['email' => __('admin.The email is already in use'), 'filed' => 'email'], 400);
                }
            }

            $phone = Auth::user()->phone;
            if ($request->phone != $phone) {
                $exisitPhone = Company::where('phone', $request->phone)->get();
                if (is_null($exisitPhone)) {

                    $phone = $request->phone;
                } else {
                    return response()->json(['phone' => __('admin.The mobile number is already in use'), 'filed' => 'phone'], 400);
                }
            }

            $company->update([
                'is_email_verified' => $is_email_verified,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $phone,
                'image' => $path,
                'address' => $request->address,
                'status' => $request->status,
                'description' => $request->description,
            ]);




            $company->categories()->sync($request->category_id);

            return json_encode(array("email" => $company->email, "name" => $company->name, "image" => $company->image));
        }
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verifyAccount($slug, $actor)
    {
        $gurad = '';
        if ($actor == 'company') {
            $gurad = Company::whereSlug($slug)->first();
        } elseif ($actor == 'trainer') {
            $gurad = Trainer::whereSlug($slug)->first();
        } elseif ($actor == 'teacher') {
            $gurad = Teacher::whereSlug($slug)->first();
        } else {
            $gurad = Admin::whereSlug($slug)->first();
        }
        if ($gurad->is_email_verified == 0) {
            $gurad->update([
                'is_email_verified' => 1
            ]);
            $message = __("admin.Email verified");
            $type = 'success';
        } else {
            $message = __("admin.Your email is already verified.");
            $type = 'warning';
        }
        return redirect()->route('admin.home')->with('verify', $message)->with('verify_type', $type);
    }



    public function editPassword($type)
    {
        if ($type == 'teacher' || $type == 'trainer' || $type == 'company' || $type == 'admin') {
            return view('admin.resetPassword', compact('type'));
        } elseif ($type == 'student') {
            return view('student.resetPassword');
        } else {
            return abort(404);
        }
    }

    public function updatePassword(Request $request)
    {


        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|max:25|confirmed',
            'new_password_confirmation' => 'required'
        ]);



        $user = Auth::guard()->user();

        //Match The current Password
        if (!Hash::check($request->current_password, $user->password)) {
            // return redirect()->back()->with('msg' , "The Current Password Doesn't match!")->with('type' , 'danger') ;
            return response()->json(['title' => __('admin.The current password is incorrect'), 'icon' => 'error'], 400);
        } elseif (Hash::check($request->current_password, $user->password) && Hash::check($request->new_password, $user->password)) {
            // return redirect()->back()->with('msg' , 'The new password can not be the current password!')->with('type' , 'danger') ;
            return response()->json(['title' => __('admin.The new password cannot be the same as the current password!'), 'icon' => 'error'], 400);
        } //new password can not be the current password!
        else {
            $user->password = Hash::make($request->new_password);
            $user->save();
            // return redirect()->back()->with('msg' , 'Updated Password is successfully')->with('type','success') ;
        }
    }


    public function all_messages_page()
    {
        Gate::authorize('messages');

        $auth = Auth::user();
        return view('admin.messages.messages', compact('auth'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Rules\TextLength;
use Illuminate\Http\Request;

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
}

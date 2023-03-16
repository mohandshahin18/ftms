<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adverts = Advert::latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.adverts.index',compact('adverts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adverts.create');
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
            'main_title'=> 'required',
            'sub_title'=> 'required',
        ]);

        if($request->image){
            $path = $request->file('image')->store('/uploads/advert', 'custom');
        }else{
            $path = public_path('studenAssets/img/advert/default.png');
        }
        if(Auth::guard('trainer')->check()){
            Advert::create([
                'main_title' => $request->main_title,
                'sub_title' => $request->sub_title,
                'image' => $path,
            ]);
        }elseif(Auth::guard('teacher')->check()){

        }elseif(Auth::guard('company')->check()){

        }else{

        }

        return redirect()->route('admin.adverts.index');
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
        //
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
}

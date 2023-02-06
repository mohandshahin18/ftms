<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainerRequest;
use App\Models\Category;
use App\Models\CategoryCompany;
use App\Models\Company;
use App\Models\Trainer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainers = Trainer::with('company')->latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::get();
        $categories = Category::get();
        return view('admin.trainers.create', compact('companies','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainerRequest $request)
    {

        $path = $request->file('image')->store('/uploads/trainer', 'custom');

        Trainer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'image' => $path,
            'company_id' => $request->company_id,
            'category_id' => $request->category_id
        ]);

        return redirect()
        ->route('admin.trainers.index')
        ->with('msg', 'Trainer Has Been Addedd Successfully')
        ->with('type', 'success');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function edit(Trainer $trainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainer  $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        if(public_path($trainer->image)) {
            try {
                File::delete(public_path($trainer->image));
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $trainer->forceDelete();
        return $trainer->id;
    }

       /**
     * return specialization based on university
     *
     */
    // public function get_category($id)
    // {
    //     $company = CategoryCompany::where('company_id', $id)->get();
    //     return json_encode($company);
    // }

}

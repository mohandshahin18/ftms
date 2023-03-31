<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\Company;
use App\Models\Trainer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoryCompany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TrainerRequest;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_trainers');
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
        Gate::authorize('add_trainer');
        $roles =Role::get();
        $companies = Company::get();
        $categories = Category::get();
        return view('admin.trainers.create', compact('companies','categories','roles'));
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

        $slug = Str::slug($request->name);
        $slugCount = Trainer::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }

        if(Auth::guard('admin')->check()) {
            $company_id = $request->company_id;
            $role_id = $request->role_id;
        } else {
            $company_id = Auth::user()->id;
            $role_id = 5;
        }

        Trainer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'company_id' => $company_id,
            'image' => $path,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'role_id' => $role_id,
        ]);

        return redirect()
        ->route('admin.trainers.index')
        ->with('msg', __('admin.Trainer has been added successfully'))
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
    public function destroy($slug)
    {
        Gate::authorize('delete_trainer');

        $trainer = Trainer::whereSlug($slug)->first();
        if(public_path($trainer->image)) {
            try {
                File::delete(public_path($trainer->image));
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $trainer->forceDelete();
        return $slug;
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


     /**
     * return specialization based on university
     *
     */
    public function get_category($id)
    {
        $company = Company::with('categories')->where('id',$id)->first();
        $categories = $company->categories->pluck("name", 'id');
        return json_encode($categories);
    }



}

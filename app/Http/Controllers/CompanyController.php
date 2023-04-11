<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;

use App\Models\CategoryCompany;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyRequest;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_companies');

        if(request()->has('keyword')){
            $companies = Company::where('name' , 'like' , '%' .request()->keyword.'%')
            ->paginate(env('PAGINATION_COUNT'));
        }else{
        $companies = Company::with('categories')->latest('id')->paginate(env('PAGINATION_COUNT '));
        }
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('add_company');
        $roles =Role::get();
        $categories = Category::get();
        return view('admin.companies.create', compact('categories','roles'));
    }


    public function slug($string, $separator = '-') {
        if (is_null($string)) {
            return "";
        }

        $string = trim($string);

        $string = mb_strtolower($string, "UTF-8");

        $string = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]#u/", "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);

        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $path = $request->file('image')->store('/uploads/company', 'custom');

        $slug = $this->slug($request->name);
        $slugCount = Company::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $count;
        }
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'password' => Hash::make($request->password),
            'image' => $path,
            'slug' => $slug,
            'role_id' => $request->role_id,
        ]);
        $company->categories()->attach($request->category_id);

        return redirect()->route('admin.companies.index')->with('msg', __('admin.Company has been added successfully'))->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        Gate::authorize('edit_company');

        $company = Company::whereSlug($slug)->first();

        $attached_categories = $company->categories()->get()->map(function($category) {
            return $category->id;
        })->toArray();

        $categories = Category::latest()->get();
        return view('admin.companies.edit', compact('categories', 'company', 'attached_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $slug)
    {
        $company = Company::whereSlug($slug)->first();

        $path = $company->image;

        if($request->image) {
            File::delete(public_path($company->image));

            $path = $request->file('image')->store('/uploads/company', 'custom');
        }

        $slug = $this->slug($request->name);
        $slugCount = Company::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }


        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'image' => $path,
            'slug' =>  $slug
        ]);

        $company->categories()->sync($request->category_id);

        return redirect()->route('admin.companies.index')->with('msg', __('admin.Company has been updated successfully'))->with('type', 'success');

    }

    /**
     * Remove the specified resource to the trash.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Gate::authorize('delete_company');

        $company = Company::whereSlug($slug)->first();

        $students = $company->students;

        foreach($students as $student) {
            $other_notifications = DB::table('notifications')
            ->where('type', 'App\Notifications\NewTaskNotification')
            ->where('notifiable_type', 'App\Models\Student')
            ->where('notifiable_id', $student->id)
            ->get();

            $acceptApply = DB::table('notifications')
            ->where('type', 'App\Notifications\AcceptApplyNotification')
            ->where('notifiable_type', 'App\Models\Student')
            ->where('notifiable_id', $student->id)
            ->get();

            $applayNotification = DB::table('notifications')
            ->where('type', 'App\Notifications\AppliedNotification')
            ->where('notifiable_type', 'App\Models\Company')
            ->where('notifiable_id', $company->id)
            ->get();

        foreach ($other_notifications as $notification) {
                DB::table('notifications')
                    ->where('id', $notification->id)
                    ->delete();

        }

        foreach ($acceptApply as $notification) {
                DB::table('notifications')
                    ->where('id', $notification->id)
                    ->delete();
        }
        foreach ($applayNotification as $notification) {
            DB::table('notifications')
                ->where('id', $notification->id)
                ->delete();
        }

            $student->company_id = null;
            $student->trainer_id = null;
            $student->category_id = null;
            $student->save();
        }




        $company->destroy($company->id);

        return $slug;
    }


    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        Gate::authorize('recycle_companies');

        if(request()->has('keyword')){
            $companies = Company::onlyTrashed()->where('name' , 'like' , '%' .request()->keyword.'%')
            ->latest('id')->paginate(env('PAGINATION_COUNT'));
        }else{
        $companies = Company::with('categories')->onlyTrashed()->latest('id')->paginate(env('PAGINATION_COUNT '));
        }
        return view('admin.companies.trash', compact('companies'));
    }

     /**
     * Restore the specified resource from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($slug)
    {
        Gate::authorize('restore_company');

        $company = Company::onlyTrashed()->whereSlug($slug)->first();

        $company->restore();
        return $slug;
    }

     /**
     * Remove the specified resource peremantly.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($slug)
    {
        Gate::authorize('forceDelete_company');

        $company = Company::onlyTrashed()->whereSlug($slug)->first();

        $path = public_path($company->image);

        if($path) {
            try {
                File::delete($path);
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $company->forceDelete();
        return $slug;

    }




}

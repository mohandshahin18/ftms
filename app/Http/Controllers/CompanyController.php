<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyRequest;
use Exception;

use Illuminate\Support\Facades\Log;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $categories = Category::get();
        return view('admin.companies.create', compact('categories'));
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

        $slug = Str::slug($request->name);
        $slugCount = Company::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 0){
            $slug = $slug . '-' . $random;
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
        ]);
        $company->categories()->attach($request->category_id);

        return redirect()->route('admin.companies.index')->with('msg', __('admin.Company has been addedd successfully'))->with('type', 'success');
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
    public function edit(Company $company)
    {
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
    public function update(CompanyRequest $request, Company $company)
    {

        $path = $company->image;

        if($request->image) {
            File::delete(public_path($company->image));

            $path = $request->file('image')->store('/uploads/company', 'custom');
        }

        $slug = Str::slug($request->name);
        $slugCount = Company::where('slug' , 'like' , $slug. '%')->count();
        $random =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $random;
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
    public function destroy($id)
    {
        Company::destroy($id);
        return $id;
    }


    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        if(request()->has('keyword')){
            $companies = Company::onlyTrashed()->where('name' , 'like' , '%' .request()->keyword.'%')
            ->paginate(env('PAGINATION_COUNT'));
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
    public function restore($id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();
        return $id;
    }

     /**
     * Remove the specified resource peremantly.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $path = public_path($company->image);

        if($path) {
            try {
                File::delete($path);
            } catch(Exception $e) {
                Log::error($e->getMessage());
            }
        }
        $company->forceDelete();
        return $id;

    }





}

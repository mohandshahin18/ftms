<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Category;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::withoutTrashed()->with('categories')->latest('id')->paginate(env('PAGINATION_COUNT '));
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

        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'password' => Hash::make($request->password),
            'image' => $path,
        ]);
        $company->categories()->attach($request->category_id);

        return redirect()->route('admin.companies.index')->with('msg', 'Company has been addedd successfully')->with('type', 'success');
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

            $path = $request->file('image')->store('/uploads', 'custom');
        }

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'image' => $path,
        ]);

        $company->categories()->syncWithoutDetaching($request->category_id);

        return redirect()->route('admin.companies.index')->with('msg', 'Company has been updated successfully')->with('type', 'success');

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
        $companies = Company::with('categories')->onlyTrashed()->latest('id')->paginate(env('PAGINATION_COUNT '));
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
        File::delete(public_path($company->image));
        $company->forceDelete();
        return $id;

    }

    
    

    
}

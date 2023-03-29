<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('all_programs');

        $categories = Category::with('companies')->withoutTrashed()->latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('add_program');

        return view('admin.categories.create');
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
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $slugCount = Category::where('slug' , 'like' , $slug. '%')->count();
        $count =  $slugCount + 1;

        if($slugCount > 1){
            $slug = $slug . '-' . $count;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,

        ]);

        return redirect()->route('admin.categories.index')->with('msg', __('admin.Program has been added successfully'))->with('type', 'success');
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
    public function update(Request $request, $slug)
    {

        $request->validate([
            'name' => 'required',
        ]);
        $categories= Category::whereSlug($slug)->first();


        $categories->name = $request->name;


        $categories->save();

        return $categories;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Gate::authorize('delete_program');

        $category = Category::whereSlug($slug)->first();
        $category->destroy($category->id);
        return $slug;
    }


    /**
     * Display a trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        Gate::authorize('recycle_programs');

        $categories = Category::onlyTrashed()->latest('id')->paginate(env('PAGINATION_COUNT'));
        return view('admin.categories.trash', compact('categories'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($slug)
    {
        Gate::authorize('restore_program');
        $category = Category::onlyTrashed()->whereSlug($slug)->first();
        $category->restore();
        return $slug;
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forcedelete($slug)
    {
        Gate::authorize('forceDelete_program');
        $category = Category::onlyTrashed()->whereSlug($slug)->first();
        $category->forcedelete();
        return $slug;




    }


}

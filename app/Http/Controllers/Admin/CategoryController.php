<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('name','asc')->where('status', 1)->get();
        return view('admin.category.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryCount = Category::count() + 1;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1, 'position' => $categoryCount]);
        Category::create($request->except('_token','picture'));
        return redirect()->route('category-crud.index')->with('success', 'Category has been created successfully!!');
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
        //$isExist = Category::find($id);
        $isExist = Category::where('id', $id)->with('country')->first();
        return view('admin.category.edit')->with('data', $isExist);
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
        $getMainCategory = Category::find($id);
        $categoryCount = Category::count();
        if($getMainCategory->position != $request->position){
            if($request->position > $categoryCount){
                return redirect()->back()->with('error', "Please select the category position less than $categoryCount");
            }
            $getOtherCategory = Category::where('position', $request->position)->first();
            if($getOtherCategory){
                $getOtherCategory->update(['position', $getMainCategory->position]);
            }
        }
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        $ll = Category::find($id)->update($request->except('_token','picture'));
        //dd($ll);
        return redirect()->route('category-crud.index')->with('success', 'Category has been updated successfully!!');
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

    /**
     * Perform the actions to the specified resource from storage.
     *
     * @param  int  $id
     * @param  string  $action
     * @return \Illuminate\Http\Response
     */
    function actions($id){
        Category::find($id)->delete();
        return redirect()->back()->with('success', 'Category has been deleted successfully');
    }
}

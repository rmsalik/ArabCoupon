<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CategoryBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = Brand::orderBy('name','asc')->where('status', 1)->get();
        return view('admin.brand.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryCount = Brand::count() + 1;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        if($request->hasFile('picture2')){
            $videoUrl = $this->uploadFile($request->file('picture2'), 0, true);
            $request->merge(['bg_image_url' => $videoUrl]);
        }
        if($request->hasFile('picture3')){
            $videoUrl = $this->uploadFile($request->file('picture3'), 0, true);
            $request->merge(['profile_image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1, 'position' => $categoryCount]);
        $brand=Brand::create($request->except('_token','picture','picture2','category_id','picture3'));
        foreach($request->category_id as $row)
        {
            //$request->merge(['country_id' => $row]);
            CategoryBrand::create(['brand_id' => $brand->id,'category_id'=>$row]);
        }
        
        
        
        return redirect()->route('brand-crud.index')->with('success', 'Brand has been created successfully!!');
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
        //$isExist = Brand::find($id);
        $isExist = Brand::where('id', $id)->with('category','country')->first();
        $selected = CategoryBrand::where('brand_id', $id)->get()->pluck('category_id')->toArray();
        return view('admin.brand.edit')->with('data', $isExist)->with('selected', $selected);
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
        $getMainCategory = Brand::find($id);
        $categoryCount = Brand::count();
        if($getMainCategory->position != $request->position){
            if($request->position > $categoryCount){
                return redirect()->back()->with('error', "Please select the brand position less than $categoryCount");
            }
            $getOtherCategory = Brand::where('position', $request->position)->first();
            if($getOtherCategory){
                $getOtherCategory->update(['position', $getMainCategory->position]);
            }
        }
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        if($request->hasFile('picture2')){
            $videoUrl = $this->uploadFile($request->file('picture2'), 0, true);
            $request->merge(['bg_image_url' => $videoUrl]);
        }
        if($request->hasFile('picture3')){
            $videoUrl = $this->uploadFile($request->file('picture3'), 0, true);
            $request->merge(['profile_image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        $ll = Brand::find($id)->update($request->except('_token','picture','category_id','picture2','picture3'));
        if(!empty($request->category_id))
        {
            CategoryBrand::where('brand_id', $id)->delete();
            foreach($request->category_id as $category_id)
            {
                $extra=[
                    'brand_id'=>$id,
                    'category_id'=>$category_id
                ];
                CategoryBrand::create($extra);
                
            }
        }
        //dd($ll);
        return redirect()->route('brand-crud.index')->with('success', 'Brand has been updated successfully!!');
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
        Brand::find($id)->delete();
        return redirect()->back()->with('success', 'Brand has been deleted successfully');
    }
}

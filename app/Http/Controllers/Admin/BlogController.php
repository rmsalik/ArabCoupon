<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Blog::orderBy('name','asc')->where('status', 1)->get();
        return view('admin.blog.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        
        Blog::create($request->except('_token','picture'));
        return redirect()->route('blog-crud.index')->with('success', 'Blog has been created successfully!!');
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
        $isExist = Blog::where('id', $id)->first();
        return view('admin.blog.edit')->with('data', $isExist);
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
        
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        $ll = Blog::find($id)->update($request->except('_token','picture'));
        //dd($ll);
        return redirect()->route('blog-crud.index')->with('success', 'Blog has been updated successfully!!');
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
        Blog::find($id)->delete();
        return redirect()->back()->with('success', 'Blog has been deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Destination::orderBy('name','asc')->where('status', 1)->get();
        return view('admin.destination.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.destination.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryCount = Destination::count() + 1;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image' => $videoUrl]);
        }
        $request->merge(['status' => 1, 'position' => $categoryCount]);
        Destination::create($request->except('_token','picture'));
        return redirect()->route('destination-crud.index')->with('success', 'Destination has been created successfully!!');
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
        $isExist = Destination::find($id);
        return view('admin.destination.edit')->with('data', $isExist);
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
        $getMainCategory = Destination::find($id);
        $categoryCount = Destination::count();
        if($getMainCategory->position != $request->position){
            if($request->position > $categoryCount){
                return redirect()->back()->with('error', "Please select the destination position less than $categoryCount");
            }
            $getOtherCategory = Destination::where('position', $request->position)->first();
            if($getOtherCategory){
                $getOtherCategory->update(['position', $getMainCategory->position]);
            }
        }
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        $ll = Destination::find($id)->update($request->except('_token','picture'));
        //dd($ll);
        return redirect()->route('destination-crud.index')->with('success', 'Destination has been updated successfully!!');
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
        Destination::find($id)->delete();
        return redirect()->back()->with('success', 'Destination has been deleted successfully');
    }
}

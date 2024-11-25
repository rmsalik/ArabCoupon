<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class TopCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Coupon::orderBy('position','asc')
        ->where('status', 1)
        ->where('is_top', 1)
        ->withCount(['couponWork','couponNotWork'])
        //->limit(10)
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->get();
        return view('admin.topcoupon.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.topcoupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryCount = Coupon::count() + 1;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1, 'position' => $categoryCount]);
        
        Coupon::create($request->except('_token','picture'));
        return redirect()->route('top-coupon-crud.index')->with('success', 'Coupon has been created successfully!!');
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
        $isExist = Coupon::where('id', $id)->with('brand','country')->first();
        return view('admin.topcoupon.edit')->with('data', $isExist);
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
        
        $getMainCategory = Coupon::find($id);
        //return $getMainCategory;
        $categoryCount = Coupon::count();
        if($getMainCategory->position != $request->position){
            if($request->position > $categoryCount){
                return redirect()->back()->with('error', "Please select the category position less than $categoryCount");
            }
            $getOtherCategory = Coupon::where('position', $request->position)->first();
            //return $getOtherCategory;
            if($getOtherCategory){
                $getOtherCategory->update(['position'=> $getMainCategory->position]);
            }
        }
        //return $request;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);
        $ll = Coupon::find($id)->update($request->except('_token','picture'));
        //dd($ll);
        return redirect()->route('top-coupon-crud.index')->with('success', 'Coupon has been updated successfully!!');
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
        Coupon::find($id)->delete();
        return redirect()->back()->with('success', 'Coupon has been deleted successfully');
    }
}

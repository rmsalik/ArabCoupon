<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\CouponItem;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return $request;
        $country=Country::all();
        $data = Coupon::orderBy('name','asc')
        ->where('status', 1)
        //->where('country_id',$request->country)
        ->with('brand','country')
        ->withCount(['couponWork','couponNotWork'])
        ->get();
        if($request->country)
        {
            $data = Coupon::orderBy('name','asc')
            ->where('status', 1)
            ->where('country_id',$request->country)
            ->with('brand','country')
            ->withCount(['couponWork','couponNotWork'])
            ->get();
        }
        return view('admin.coupon.index')->with(compact('data','country'));
    }
    public function indexApi()
    {
        //return 122222;
        
        $data = Coupon::orderBy('name','asc')
        ->where('status', 2)
        ->with('brand','country')
        ->withCount(['couponWork','couponNotWork'])
        ->get();
        return view('admin.coupon.indexapi')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
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
        //return $request;
        if($request->hasFile('picture')){
            $videoUrl = $this->uploadFile($request->file('picture'), 0, true);
            $request->merge(['image_url' => $videoUrl]);
        }
        $request->merge(['status' => 1, 'position' => $categoryCount]);
        foreach($request->countries as $row)
        {
            $request->merge(['country_id' => $row]);
            Coupon::create($request->except('_token','picture','countries'));
        }
        
        return redirect()->route('coupon-crud.index')->with('success', 'Coupon has been created successfully!!');
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
    public function copyCoupon($id)
    {
        //$isExist = Brand::find($id);
        $isExist = Coupon::where('id', $id)->with('brand','country')->first();
        return view('admin.coupon.copy')->with('data', $isExist);
    }
    public function copyDeleteCoupon(Request $request)
    {
        //return $request->coupon_ids;
        $ids=$request->coupon_ids;
        //r eturn $ids;
        $delete=Coupon::whereIn('id',$ids)->delete();
        return redirect()->back()->with('success', 'Coupons has been deleted successfully');
        //$isExist = Brand::find($id);
        //$isExist = Coupon::where('id', $id)->with('brand','country')->first();
        //return view('admin.coupon.copy')->with('data', $isExist);
    }
    public function edit($id)
    {
        //$isExist = Brand::find($id);
        $data = Coupon::where('id', $id)->with('brand','country')->first();
        $country = Coupon::where('country_id', $data->country_id)->with('brand','country')->get();
        $selected = CouponItem::where('coupon_id', $id)->get()->pluck('item_id')->toArray();
        //return $selected;
        return view('admin.coupon.edit')->with(compact('data','country','selected'));
        //->with('data', $isExist);
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
        
        if(!empty($request->coupon_id))
        {
            CouponItem::where('coupon_id', $id)->delete();
            foreach($request->coupon_id as $coupon_id)
            {
                $extra=[
                    'coupon_id'=>$id,
                    'item_id'=>$coupon_id
                ];
                CouponItem::create($extra);
                
            }
        }
        //return $request->coupon_id;
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
        $ll = Coupon::find($id)->update($request->except('_token','picture','coupon_id'));
        //dd($ll);
        return redirect()->route('coupon-crud.index')->with('success', 'Coupon has been updated successfully!!');
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

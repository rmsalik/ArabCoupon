<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Trip::orderBy('id','asc')
        //->where('status', 1)
        ->with(['user','item'])->get();
        return view('admin.booking.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if($request->hasFile('video')){
            $videoUrl = $this->uploadFile($request->file('video'), 0, true);
            // $thumbImageUrl = $this->videoThumbImage($request->file('video'));
            $request->merge(['thumb_image_url' => $videoUrl, 'file_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);

        $item=Item::create($request->except('_token','photos'));
        if($files=$request->file('photos')){
            //ini_set('max_execution_time', '0'); // for infinite time of execution
            $images = [];
            foreach($files as $f=>$file){
                $imageUrl = $this->uploadFile($file, 0, true);
                    $images[$f]['name']=$imageUrl;
                    $images[$f]['item_id']=$item->id;
                    $images[$f]['created_at']=Carbon::now();
                    $images[$f]['updated_at']=Carbon::now();
                
            }
            if(count($images)>0)
            ItemImage::insert($images);
        }
        return redirect()->route('item-crud.index')->with('success', 'Vehicle has been created successfully!!');
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
        $isExist = Trip::where('id', $id)->with(['user','item.images','before_image','after_image'])->first();
        //return $isExist;
        return view('admin.booking.show')->with('data',$isExist);
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
        $validator = Validator::make($request->all(), [
            //'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        if($request->hasFile('video')){
            $videoUrl = $this->uploadFile($request->file('video'), 0, true);
            // $thumbImageUrl = $this->videoThumbImage($request->file('video'));
            $request->merge(['thumb_image_url' => $videoUrl, 'file_url' => $videoUrl]);
        }
        $request->merge(['status' => 1]);

        Item::find($id)->update($request->except('_token','photos'));
        if($files=$request->file('photos')){
            //ini_set('max_execution_time', '0'); // for infinite time of execution
            $images = [];
            foreach($files as $f=>$file){
                $imageUrl = $this->uploadFile($file, 0, true);
                    $images[$f]['name']=$imageUrl;
                    $images[$f]['item_id']=$id;
                    $images[$f]['created_at']=Carbon::now();
                    $images[$f]['updated_at']=Carbon::now();
                
            }
            if(count($images)>0)
            ItemImage::insert($images);
        }
        return redirect()->route('item-crud.index')->with('success', 'Vehicle has been updated successfully!!');
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
        Item::find($id)->delete();
        return redirect()->back()->with('success', 'Vehicle has been deleted successfully');
    }
}

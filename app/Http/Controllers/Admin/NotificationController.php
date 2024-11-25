<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getData = Notification::all();
        return view('admin.notification.list',compact('getData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(1);
        return view('admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notification = Notification::create([
            'title'=>$request->title,
            'message'=>$request->message,
        ]);
        // return $notification;
        $firebaseToken = User::where('device_token','!=','')
        ->where('notify',1)
        //->where('id',534)
        ->distinct()
        ->pluck('device_token')->all();
        //return  $firebaseToken;
        //$SERVER_API_KEY ='AAAAH7gYTF8:APA91bFuYnJhvMAtReQ_dWL2b2FEmQS9j5zQgmutd0ccs9UIy_sK0jGM1383j92BNIRwdoRVDrOXL2lY0O3ElooJZdqgX8G6PcWW4QgRmjfl7FS40GEZkijBYRkDrSZf87yM9do51R_N';
        //$SERVER_API_KEY ='AAAAH7gYTF8:APA91bF41AETnDWDBiFGR2VUHiz8-R2sNBWVgIL_Rq7e4t--aiU0Tuaj8HfMV5zCyxy-3ULQRamCFFYRJyvzS2HashcAZpvrNFNHWpSIkFUwdaqMmtypzqXFGc7fHjtneZkNBhM0uBsJ';
        //$GOOGLE_API_KEY = 'AAAAH7gYTF8:APA91bF41AETnDWDBiFGR2VUHiz8-R2sNBWVgIL_Rq7e4t--aiU0Tuaj8HfMV5zCyxy-3ULQRamCFFYRJyvzS2HashcAZpvrNFNHWpSIkFUwdaqMmtypzqXFGc7fHjtneZkNBhM0uBsJ';
        $SERVER_API_KEY = 'AAAAH7gYTF8:APA91bFuYnJhvMAtReQ_dWL2b2FEmQS9j5zQgmutd0ccs9UIy_sK0jGM1383j92BNIRwdoRVDrOXL2lY0O3ElooJZdqgX8G6PcWW4QgRmjfl7FS40GEZkijBYRkDrSZf87yM9do51R_N';
        //return $firebaseToken;
        //return $SERVER_API_KEY;
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->message, 
            ]
        ];
        //return $data;
        $dataString = json_encode($data);
        //return $dataString;
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        //return $headers;
    //   return $headers;
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
        //return $response;

        return redirect()->back()->with('success','Notification has been sent successfully');
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
        $getData = Notification::find($id);
        return view('admin.notification.edit',compact('getData'));
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
        $getData = Notification::find($id);
        $getData->title = $request->title;
        $getData->message = $request->message;
        $getData->update();
        return redirect()->route('notification.index')->with('success', 'Notification has been Updated successfully');



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

    function actions($id){
        // dd(1);
        //return $id;
        $yes =Notification::find($id)->delete();
        //dd($yes);
        return redirect()->back()->with('success', 'Notification has been deleted successfully');
    }
}

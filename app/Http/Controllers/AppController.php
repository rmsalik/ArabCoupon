<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    var $usersFields = ["users.id","users.full_name","users.email","users.image_url","users.user_type","users.created_at"];
    var $chatFields = ["chats.id","chats.from_id","chats.to_id","chats.conversation_id","chats.message","chats.is_label","chats.status","chats.created_at"];
    var $inviteListFields = ["users.id","users.full_name","users.image_url"];

    private function trimRoute($route)
    {
        $indexOf = strpos($route, '{');
        if ($indexOf > 0)
            return substr($route, 0, $indexOf - 1);

        return $route;
    }

    function validation(Request $request,$route=false){
        if(!$route) {
            $route = $request->route();
            if (is_null($route)) {
                if ($request->ajax()) {
                    return response(['error'=>true,'message'=>'Invalid route!'], 500);
                } else
                    return ['error' => true, 'message' => 'Invalid route!'];
            }
            $route = $this->trimRoute($route->uri);
        }
        $required = config('assets.' . $route.'.required');
        $optional = config('assets.' . $route.'.optional');
        if(count($optional)>0){
            foreach ($optional as $key=>$val) {
                if( ($request->has($key) && ( $request->input($key)=="0" || $request->input($key) ) ) || $request->hasFile($key)){
                    $required[$key]=$val;
                }
            }
        }
        /* $messages = [
             'accessKey.required'=>__('notification.loginTA')
         ];*/
        $validator = Validator::make($request->all(),$required/*,$messages*/);
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            if($request->ajax() || strpos($route,'api/') !== false) {
                $this->jsonOutput(['error'=>true,'message'=>$errors]); return false;
            }
            else
                return ['error'=>true,'message'=>$errors];
        }else{
            $dataToSave = [];
            foreach ($required as $key=>$val) {
                if(!is_array($request->input($key)))
                    $dataToSave[$key] = $request->input($key);
            }
            $dataToSave = $this->changeToArray($dataToSave);
            return $dataToSave;
        }
    }

    function jsonOutput($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);exit;
    }

    function changeToArray($set){
        $array=[];
        foreach ($set as $key => $value) {
            Arr::set($array, $key, $value);
        }
        return $array;
    }

    function access_token($user){
        return $user->createToken('API_AUTHORIZATION')->accessToken;
    }

    function getConversationId($length = 6){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $isExits = Chat::where('conversation_id',$randomString)->first();
        if($isExits==null)
            return $randomString;
        else {
            $this->getConversationId();
        }
        return true;
        //return ($input['from_id']*$input['to_id'])+($input['from_id']+$input['to_id']);
    }

    function pushNotification($data,$deviceType,$toType='Guest'){
        try {
            //$GOOGLE_API_KEY = 'AAAArWxcp4U:APA91bFQgA--JMsNoROaRS7Sn2mdOH3_NqcFRjINv9nQ3Drzm1pDuwaEKA-y4-tb8_2JvNZLk-R2EwNisc09jCQuXlMCAWa0HpLN4KtnnNIezergVMtWM7v2iWwJ5XuNytWjWg-XwUFf';
            //$GOOGLE_API_KEY = 'AAAAyc-3i6M:APA91bEBccYqeCGTS0uu81PE6mb10wgsjM1IqjRvqpuc1ElHxiv4h-yJEX-9zFIquZWUZqKQkd0X5G9IfV7799EmXm68so6ufrY8z-7o9P0eMf5gbpmQppQQ480w95EzofnbCo47Qly9';
            //$GOOGLE_API_KEY = 'AAAAiLTOw7A:APA91bHCR14aH1XNgo0d-Fb1ww6KXSrGOkqz32ptSZUmtZp4zIHtRlOq61Bo4szqX-SRlzuN0ousrrK5hU2sXftFz0LQV82VVz41t-ATAdlHbwRrtvDTMmvJRy101lV2YSycSpwnb9ID';
            //$GOOGLE_API_KEY = 'AAAAH7gYTF8:APA91bF41AETnDWDBiFGR2VUHiz8-R2sNBWVgIL_Rq7e4t--aiU0Tuaj8HfMV5zCyxy-3ULQRamCFFYRJyvzS2HashcAZpvrNFNHWpSIkFUwdaqMmtypzqXFGc7fHjtneZkNBhM0uBsJ';
            $GOOGLE_API_KEY = 'AAAAH7gYTF8:APA91bFuYnJhvMAtReQ_dWL2b2FEmQS9j5zQgmutd0ccs9UIy_sK0jGM1383j92BNIRwdoRVDrOXL2lY0O3ElooJZdqgX8G6PcWW4QgRmjfl7FS40GEZkijBYRkDrSZf87yM9do51R_N';
            
            //FCM API end-point
            $url = 'https://fcm.googleapis.com/fcm/send';
            $payLoad =
                [
                    "to" => $data['to'],
                    'priority' => "high",
                    "notification" => [
                        "body" => $data['message'],
                        "title" => $data['subject'],
                        "type" => $data['type'],
                        "sound" => "default",
                        'badge' => isset($data['badge']) ? $data['badge'] : 0
                    ],
                    "data" => json_decode($data['customData'])
                ];
            $headers = array(
                'Authorization: key=' . $GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payLoad));

            // Execute post
            $result = curl_exec($ch);
            //return $result;
            //debug($result);exit;
            if ($result === FALSE) {
                //die('Curl failed: ' . curl_error($ch));
                return false;
            }

            //dd($result);
            // Close connection
            curl_close($ch);

            return true;
        }catch(\Exception $e){
            //return false;
            dd($e);
        }
    }
}

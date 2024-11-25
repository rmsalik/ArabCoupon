<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use FFMpeg;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected const SECRETE_KEY_FOR_STRIPE = "sk_test_51LWfRHIKMkIGJywlvygmG8vLisr3rU7pQdccBGP0JiviX0seDgTCVky8RzcEA0ToFlHrRBnZiFWPPEyKsiWSTRMM00VCUmIzRX";

    protected const BASE_ITEM_PATH = 'admin_uploads';
    protected const BASE_USER_IMAGE_PATH = 'user_files/user_';
    protected function uploadFile($fileObject, $userId, $destinationPath = false)
    {
        $time = time();
        $extension = $fileObject->getClientOriginalExtension();
        $fileName  = str_replace(" ", "_", $fileObject->getClientOriginalName());
        $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
        !$destinationPath
        ?   $destinationPath = public_path(self::BASE_USER_IMAGE_PATH . $userId)
        :   $destinationPath = public_path(self::BASE_ITEM_PATH);

        if (!file_exists($destinationPath)) {
            //create folder
            mkdir($destinationPath, 0755, true);
        }
        $fileObject->move($destinationPath, $fileNameWithoutEx . "_" . $time . "." . $extension);
        return $fileNameWithoutEx . "_" . $time . "." . $extension;
    }
    protected function videoThumbImage($fileObject)
    {
        $destinationPath = public_path(self::BASE_ITEM_PATH);
        $thumbImage = str_replace(" ", "_", $fileObject->getClientOriginalName()) . "_" . time() . "_" . '.' . $fileObject->getClientOriginalExtension();
        $ffmpeg = FFMpeg\FFMpeg::create();
            // ----------------Taking Screen shot for thumb image---------
            $video = $ffmpeg->open($fileObject);
            $video
                ->filters()
                ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
                ->synchronize();
            $video
                ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
                ->save($destinationPath . "/$thumbImage");
        return $thumbImage;
    }
    function pushNotification($data,$deviceType,$toType='Guest'){
        //return $data;
        //try {
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
                    "data" => $data['customData']
                ];
            $headers = array(
                'Authorization: key=' . $GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            // Open connection
            $ch = curl_init();
            //return $payLoad;
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
            return $result;
            exit;
            //echo $result;
            
            //debug($result);exit;
            if ($result === FALSE) {
                //die('Curl failed: ' . curl_error($ch));
                return false;
            }

            //dd($result);
            // Close connection
            curl_close($ch);

            return true;
       // }catch(\Exception $e){
            //return false;
        //    dd($e);
        //}
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends AppController
{
    function getMyChats(Request $request){
        try {

            $user = $request->user();
            //return $user;
            $data = Chat::select($this->chatFields)
                ->whereIn('id', function($query) use ($user){
                    $query->selectRaw('MAX(`id`)')
                        ->from('chats')
                        ->where(function ($query) use ($user) {
                            $query->orwhere('from_id',$user->id);
                            $query->orwhere('to_id',$user->id);
                        })->groupBy('conversation_id');
                })->with('from','to')->orderBy('id','desc')->get();
            //return $data;
            foreach ($data as $chat) {
                // manipulate chat_room_categories
                //$chat->chat_room->chat_room_categories = new \stdClass();

                if($chat->to==null) {
                    unset($chat->to);
                    $chat->to = new \stdClass();
                }
            }

            $response = ['error'=>false,'message'=>'','data'=>$data];
            return response($response, 200);

        }catch (\Exception $exception){
            $response = ['error'=>true,'message'=>$exception->getMessage()];
            return response($response, 500);
        }
    }
    function getListChats(Request $request){
        try {

            $user = $request->user();
            //$sub='1';
            //if($request->is_subscribe == 1)
            //{
            //    $sub='';
            //}
            //$sub='1';
            //$subscribe_list = User::select('id','full_name','plan_id')->where('plan_id','!=',$sub)->get()->pluck('id');
            //return $subscribe_list;
            //return $user;
            $data = Chat::select($this->chatFields)
                ->whereIn('id', function($query) use ($user){
                    $query->selectRaw('MAX(`id`)')
                        ->from('chats')
                        //->orwhereIn('to_id',$subscribe_list)
                        //->orwhereIn('from_id',$subscribe_list)
                        ->where(function ($query) use ($user) {
                            $query->orwhere('from_id',$user->id);
                            $query->orwhere('to_id',$user->id);
                        })->groupBy('conversation_id');
                })->with(['from','to'])->orderBy('id','desc')->get();

            foreach ($data as $chat) {
                // manipulate chat_room_categories
                //$chat->chat_room->chat_room_categories = new \stdClass();

                if($chat->to==null) {
                    unset($chat->to);
                    $chat->to = new \stdClass();
                }
            }
            //$adata['grade_year'] = auth()->user()->grade_year;
            //$adata['school_name'] = auth()->user()->school_name;
            //$adata['state'] = auth()->user()->state;
            //$adata['gpa'] = auth()->user()->gpa;

            $response = ['error'=>false,'message'=>'Chat List','data'=>$data];
            return response($response, 200);

        }catch (\Exception $exception){
            $response = ['error'=>true,'message'=>$exception->getMessage()];
            return response($response, 500);
        }
    }

    function initiateChat(Request $request){
        try {
            // start transaction
            DB::beginTransaction();

            $input = $this->validation($request);
            $input['from_id'] = $request->user()->id;
            // check is chat already initiated
            $isInitiated = Chat::select('conversation_id')->where(function ($q) use ($input){
                $q->orWhere(function ($query) use ($input){
                    $query->where('from_id',$input['from_id'] )
                        ->where('to_id',$input['to_id'] );
                })->orWhere(function ($query) use ($input){
                    $query->where('from_id',$input['to_id'] )
                        ->where('to_id',$input['from_id'] );
                });
            })->first();
            if($isInitiated == null){
                $input = array_merge($input, ['conversation_id' => $this->getConversationId(), 'message' => $request->user()->first_name . " say's hi...!", 'is_label' => 1]);
                $chat = Chat::create($input);
                $data = Chat::select($this->chatFields)->where('id', $chat->id)->with(['from','to'])->first();
            }else {
                $data = Chat::select($this->chatFields)->where('conversation_id',$isInitiated->conversation_id)->with(['from','to'])->orderBy('id','desc')->first();
            }

            // commit transaction
            DB::commit();

            $response = ['error'=>false,'message'=>'Chat has been initiated successfully!','data'=>$data];
            return response($response, 200);

        }catch (\Exception $exception){
            // rollback transaction
            DB::rollBack();

            $response = ['error'=>true,'message'=>$exception->getMessage()];
            return response($response, 500);
        }
    }

    function chat(Request $request){
        try {
            // start transaction
            DB::beginTransaction();

            $input = $this->validation($request);
            $fromId = $input['from_id'] = $request->user()->id;

            // one-to-one chat
            $toGetToId = Chat::where('conversation_id',$input['conversation_id'])->where(function ($query) use ($fromId){
                $query->orwhere('from_id',$fromId);
                $query->orwhere('to_id',$fromId);
            })->first();
            //return $toGetToId;
            if($toGetToId->from_id == $fromId)
                $toId = $toGetToId->to_id;
            else
                $toId = $toGetToId->from_id;
            //return $toId;
            $input = array_merge($input,['to_id'=>$toId]);
            //return $input;

            $chat = Chat::create($input);
            $data = Chat::select($this->chatFields)
            ->where('id',$chat->id)
            ->first();
            $data2=[
                "id" => $data->id,
                "from_id"=> $data->from_id,
                "to_id"=> $data->to_id,
                "conversation_id" =>$data->conversation_id,
                "message"=> $data->message,
                "is_label"=> $data->is_label,
                "status"=> $data->status,
                "created_at"=> $data->created_at,
                "to_full_name"=> $chat->to_info->full_name,
                "to_image_url"=> $chat->to_info->image_url,
                "from_full_name"=> $chat->from_info->full_name,
                "from_image_url"=> $chat->from_info->image_url
            ];
            //return $data2;
           // $data_extra['chat'] = $chat;
            //$data_extra['to'] = $chat->to_info;
            //return $chat->to_info;
            // send push to owner
            //return $data;
            $extra=json_encode($data2);
            //return $chat->to_info;
            //dd($chat->to_info);
            $to_info=isset($chat->to_info->device_token)?$chat->to_info->device_token:'';
            $to_device=isset($chat->to_info->device_type)?$chat->to_info->device_type:'';
            $payLoad=[/*'badge'=>getBadge($chat->id,'Owner'),*/'subject'=>'Message','type'=>'Chat','to'=>$to_info,'message'=>$data->message,'customData'=>$extra];
            $isSent = $this->pushNotification($payLoad, $to_device);
            //return $isSent;

            // commit transaction
            DB::commit();

            $response = ['error'=>false,'message'=>'Message has been sent successfully!','data'=>$data];
            return response($response, 200);

        }catch (\Exception $exception){
            // rollback transaction
            DB::rollBack();

            $response = ['error'=>true,'message'=>$exception->getMessage()];
            return response($response, 500);
        }
    }

    function chatDetail(Request $request){
        try {
            $input = $this->validation($request);
            $fromId = $input['from_id'] = $request->user()->id;
            $isUserBelongedToChat = Chat::where('conversation_id',$input['conversation_id'])->where(function ($query) use ($fromId){
                $query->orwhere('from_id',$fromId);
                $query->orwhere('to_id',$fromId);
            })->count();
            if($isUserBelongedToChat > 0) {
                $messages = Chat::select($this->chatFields)->where('conversation_id', $input['conversation_id'])/*->where(function ($query) use ($fromId){
                    $query->orwhere('from_id',$fromId);
                    $query->orwhere('to_id',$fromId);
                })*/ ->with('from','to')->get();
                $response = ['error'=>false,'message'=>'','data'=>$messages];
                return response($response, 200);
            }else{
                $response = ['error'=>true,'message'=>'You are not a member of this conversation'];
                return response($response, 500);
            }


        }catch (\Exception $exception){
            $response = ['error'=>true,'message'=>$exception->getMessage()];
            return response($response, 500);
        }
    }

    function getInvitesList(){
        $data = User::select($this->inviteListFields)->where('status',1)->get();
        $response = ['error'=>false,'message'=>'','data'=>$data];
        return response($response, 200);
    }
}

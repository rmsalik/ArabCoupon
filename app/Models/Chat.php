<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_id', 'to_id', 'conversation_id', 'message', 'chat_room_id', 'is_label', 'status'
    ];

    public function from()
    {
        return $this->belongsTo(User::class,'from_id')->select(['id','full_name','email','image_url']);
    }

    public function to()
    {
        return $this->belongsTo(User::class,'to_id')->select(['id','full_name','email','image_url']);
    }
    

    public function to_info()
    {
        return $this->belongsTo(User::class,'to_id')->select(['id','full_name','image_url','device_type','device_token']);
    }
    public function from_info()
    {
        return $this->belongsTo(User::class,'from_id')->select(['id','full_name','image_url','device_type','device_token']);
    }
}

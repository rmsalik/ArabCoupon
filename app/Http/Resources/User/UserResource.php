<?php

namespace App\Http\Resources\User;
use App\Models\{User,CreditCard};

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $card=CreditCard::where('user_id',$this->id)->where('is_default',1)->first();
        return [
            'id'         => $this->id,
            'full_name'  => $this->full_name ?? "" ,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'profile_type'  => $this->profile_type,
            'age'  => $this->age,
            'image_url'  => $this->image_url,
            'front_license_url'  => $this->front_license,
            'back_license_image'  => $this->back_license,
            'upload_insurance_document_image'  => $this->document,
            'user_type'  => $this->user_type,
            'stripe_customer_id'=> is_null($this->stripe_customer_id)?'':$this->stripe_customer_id,
            'destination_id'  => $this->destination_id,
            'device_type'  => $this->device_type,
            'device_token'  => $this->device_token,
            'is_profile_complete'  => $this->is_profile_complete?? 0,
            'isProfileComplete'  => strval($this->is_profile_complete)?? "",
            'number_of_trips'  => count($this->trips),
            'status'     => $this->status == 1 || !isset($this->status) ? true : false,
            'is_admin'     => $this->is_admin == 1 || !isset($this->is_admin) ? true : false,
            'default_card'=>!empty($card)?new CreditCardResource(CreditCard::find($card->id)):(object)[],
            //'is_social' => count($this->userSocial) ? true : false,
            //'is_subscribed' => count($this->subscription) ? true : false,
            //'subscribed_package' => count($this->subscription) ? $this->subscription[0]->package_name : "",
            //'subscription_is_cancelled' => count($this->subscription) ? (bool) $this->subscription[0]->is_cancelled : "",
        ];
    }
}

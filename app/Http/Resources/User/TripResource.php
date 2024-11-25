<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Item,User,CreditCard};
use Carbon\Carbon;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $start = strtotime($this->start_date);
        $end = strtotime($this->end_date);
        $card=CreditCard::where('user_id',$this->user_id)->where('is_default',1)->first();
        $status='';
        if($this->status == 0)
        {
            $status = 'Cencelled';
        }
        if($this->status == 1)
        {
            $status = 'Completed';
        }
        if($this->status == 2)
        {
            $status = 'Upcoming';
        }
        
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            's_date'=>Carbon::createFromFormat('Y-m-d', $this->start_date)->format('F d'),
            'e_date'=>Carbon::createFromFormat('Y-m-d', $this->end_date)->format('F d'),
            'no_of_days'=> ceil(abs($end - $start) / 86400),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'destination' => $this->destination,
            'pickup_lat' => $this->pickup_lat,
            'pickup_lng' => $this->pickup_lng,
            'drop_lat' => $this->drop_lat,
            'drop_lng' => $this->drop_lng,
            'pickup_location' => $this->pickup_location,
            'drop_location' => $this->drop_location,
            'location_type' => $this->location_type,
            'tax' => $this->tax,
            'state' => $this->state,
            'extra_fees' => $this->extra_fees,
            'booking_type' => $this->booking_type,
            'tax_percentage' => $this->tax_percentage,
            'total_bill' => $this->total_bill,
            'price' => $this->price,
            'payment_type' => $this->payment_type,
            'delivery_fees' => $this->delivery_fees,
            'insurance_fees' => $this->insurance_fees,
            'fuel_fees' => $this->fuel_fees,
            'pickup_fees' => $this->pickup_fees,
            'dropoff_fees' => $this->dropoff_fees,
            'pickupanddropoff_fees' => $this->pickupanddropoff_fees,
            'status' => $status,
            'stars'=>isset($this->stars->stars)?$this->stars->stars:0,
            'vehicle_details' => new ItemResource(Item::find($this->item_id)),
            'user_details' => new UserResource(User::find($this->user_id)),
            'before_images'=>$this->before_image,
            'after_images'=>$this->after_image,
            'credit_card_details'=>!empty($card)?new CreditCardResource(CreditCard::find($card->id)):(object)[],
            
        ];
    }
}

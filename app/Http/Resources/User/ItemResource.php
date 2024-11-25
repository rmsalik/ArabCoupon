<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Item,User,Trip,CreditCard};
use Carbon\Carbon;


class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
     
    public function toArray($request)
    {
        $trip=Trip::where('item_id',$this->id)
        //->where('status',1)
        //->where('end_date','<',date('Y-m-d'))
        ->orderby('id','desc')
        ->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            //'brand_name' => $this->brand_name,
            'price' => $this->price,
            'delivery_fees' => $this->delivery_fees,
            'insurance_fees' => $this->insurance_fees,
            'fuel_fees' => $this->fuel_fees,
            'pickup_fees' => $this->pickup_fees,
            'dropoff_fees' => $this->dropoff_fees,
            'pickupanddropoff_fees' => $this->pickupanddropoff_fees,
            //'state' => $this->state,
            'city' => $this->city,
            'location' => $this->location,
            'car_color' => $this->car_color,
            'car_number' => $this->car_number,
            'car_model' => $this->car_model,
            'seating_capacity' => $this->seating_capacity,
            'body_type' => $this->body_type,
            'engine' => $this->engine,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'interior' => $this->interior,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'status' => $this->status,
            'totat_trips' => count($this->trips),
            'totat_stars' => (count($this->stars) > 0) ?$this->stars->sum('stars')/count($this->stars): 0,
            'is_like' => count($this->isLikedByMe) ? true : false,
            'category' => $this->category,
            'destination' => $this->destination,
            'brand' => $this->brand,
            'images' => $this->images,
            'last_trip'=>is_null($trip)?'':'('.Carbon::createFromFormat('Y-m-d', $trip->start_date)->format('F d').' - '.Carbon::createFromFormat('Y-m-d', $trip->end_date)->format('F d').')',
            //'last_trip'=>is_null($trip)?[]:new TripResource(Trip::find($trip->id))
            //'is_free' => (bool) $this->is_free,
            
        ];
    }
}

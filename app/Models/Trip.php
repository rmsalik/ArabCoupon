<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class)->select('id','name');;
    }
    /**
     * Define Relationships
     */
    public function before_image()
    {
        return $this->hasMany(TripImage::class)->where(['type' => 'before']);
    }
    public function after_image()
    {
        return $this->hasMany(TripImage::class)->where(['type' => 'after']);
    }
    public function stars()
    {
        return $this->hasOne(TripStar::class)->where(['user_id' => auth()->id()]);
    }
}

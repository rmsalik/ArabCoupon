<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
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
    public function userLikeItem()
    {
        return $this->hasMany(UserLikeItem::class);
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
    public function stars()
    {
        return $this->hasMany(TripStar::class);
    }
    public function isLikedByMe()
    {
        return $this->hasMany(UserLikeItem::class)->where(['user_id' => auth()->id(), 'is_like' => true]);
    }
    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name');;
    }
    public function destination()
    {
        return $this->belongsTo(Destination::class)->select('id','name');;
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_name')->select('id','name');;
    }
    public function images()
    {
        return $this->hasMany(ItemImage::class)->select('id','item_id','name');
    }
    /**
     * Accessors
     */
    public function getFileUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
    public function getThumbImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
}

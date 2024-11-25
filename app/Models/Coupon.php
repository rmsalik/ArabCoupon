<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Define all the Relationships
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name','arabic_name','description');
    }
    public function country()
    {
        return $this->belongsTo(Country::class)->select('id','name','arabic_name','image_url');
    }
    public function couponWork()
    {
        return $this->hasMany(CouponLike::class)->where('is_like', true);
    }
    public function couponNotWork()
    {
        return $this->hasMany(CouponLike::class)->where('is_like', false);
    }
    public function getImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
}

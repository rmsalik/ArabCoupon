<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
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
    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name','description');
    }
    public function categoryAr()
    {
        return $this->belongsTo(Category::class,'category_id')->select('id','arabic_name as name');
    }
    public function country()
    {
        return $this->belongsTo(Country::class)->select('id','name','arabic_name','image_url');
    }
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
        //->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
    }
    public function couponsAr()
    {
        return $this->hasMany(Coupon::class)
        ->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
    }
    public function getImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
    public function getBgImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
    public function getProfileImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
}

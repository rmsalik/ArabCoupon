<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function brand()
    {
        return $this->hasMany(Brand::class);
        //->select('id','category_id','name','description','image_url','url_link','status');
    }
    public function country()
    {
        return $this->belongsTo(Country::class)->select('id','name','arabic_name','image_url');
    }
    public function brandAr()
    {
        return $this->hasMany(Brand::class)
        ->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
    }
    function brands(){
        return $this->belongsToMany(Brand::class);
    }
    public function getImageUrlAttribute($value)
    {
        return url("admin_uploads/$value");
    }
}

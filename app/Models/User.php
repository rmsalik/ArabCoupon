<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'deleted_at',
        'email_verified_at',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];

    /**
     * Mutator for Password Hashing
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function credit_cards()
    {
        return $this->hasMany(CreditCard::class)->orderBy('is_default', 'DESC');
    }
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Define all the Relationships
     */
    public function userLikeItem()
    {
        return $this->hasMany(UserLikeItem::class)->where('is_like', true);
    }
    public function userSocial(){
        return $this->hasMany(UserSocial::class);
    }
    public function subscription(){
        return $this->hasMany(Subscription::class)->where('status', true);
    }

    /**
     * Accessor for Image URL
     */
    public function getImageUrlAttribute($value)
    {
        return ($value) ? url('user_files/user_' . $this->id . '/' . $value) : '';
    }
    public function getDocumentAttribute($value)
    {
        return ($value) ? url('user_files/user_' . $this->id . '/' . $value) : '';
    }
    public function getFrontLicenseAttribute($value)
    {
        return ($value) ? url('user_files/user_' . $this->id . '/' . $value) : '';
    }
    public function getBackLicenseAttribute($value)
    {
        return ($value) ? url('user_files/user_' . $this->id . '/' . $value) : '';
    }

    /**
     * This method is used to create user
     */
    public static function createUser($data){
        return User::create($data);
    }
    /**
     * This method is used to get single User by ID or Email
     */
    public static function getUser($data){
        return User::where('id', $data)->orWhere('email', $data)->first();
    }
    /**
     * This method is used to update User
     */
    public static function updateUser($id, $data){
        return User::findOrFail($id)->update($data);
    }
}

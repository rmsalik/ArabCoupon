<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
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
   public function getIsOfficeExitAttribute($value)
    {
        if($value == "Yes")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

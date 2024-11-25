<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeItem extends Model
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
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'item_id');
    }
}

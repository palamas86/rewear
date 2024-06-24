<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    use HasFactory;

    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AuctionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'starting_bid',
        'current_bid',
        'image',
        'auction_end'
    ];

    public static function create(array $attributes = [])
    {
        $attributes['auction_end'] = now(); // Default auction duration
        return parent::create($attributes);
    }

    protected $casts = [
        'auction_end' => 'datetime',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}

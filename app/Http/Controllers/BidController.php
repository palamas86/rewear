<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AuctionItem;
use App\bid;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'auction_item_id' => 'required|exists:auction_items,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $auctionItem = AuctionItem::findOrFail($request->auction_item_id);
        $currentBid = $auctionItem->bids()->max('amount') ?? $auctionItem->starting_bid;

        if ($request->amount <= $currentBid) {
            return back()->withErrors(['amount' => 'Bid must be higher than the current bid.']);
        }

        $bid = new Bid();
        $bid->auction_item_id = $auctionItem->id;
        $bid->user_id = Auth::id();
        $bid->amount = $request->amount;
        $bid->save();

        $auctionItem->current_bid = $bid->amount;
        $auctionItem->save();

        return back()->with('success', 'Your bid has been placed.');
    }
}

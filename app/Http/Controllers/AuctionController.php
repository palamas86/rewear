<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AuctionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class AuctionController extends Controller
{
    public function index()
    {
        $auctionItems = AuctionItem::all();

        return view('auction.index', compact('auctionItems'));
    }

    public function show($id)
    {
        $auctionItem = AuctionItem::findOrFail($id);
        $currentTime = now();
        $auctionEnded = $auctionItem->auction_end < $currentTime;
        $highestBid = $auctionItem->bids->max('amount');
        $highestBidder = $auctionItem->bids->where('amount', $highestBid)->first()->user_id ?? null;
        $isHighestBidder = Auth::id() == $highestBidder;
        $cartItems = [];

        return view('auction.show', compact('auctionItem', 'currentTime', 'auctionEnded', 'highestBid', 'highestBidder', 'isHighestBidder', 'cartItems'));
    }
    public function store(Request $request)
    {
        // Validasi dan penyimpanan item lelang
        $auctionItem = new AuctionItem();
        $auctionItem->title = $request->title;
        $auctionItem->description = $request->description;
        $auctionItem->starting_bid = $request->starting_bid;
        $auctionItem->auction_end = now()->addHours(24); // Misalnya, lelang berlangsung selama 24 jam
        $auctionItem->save();

        // Redirect atau respons sesuai kebutuhan aplikasi
    }
    public function checkoutAuction($itemId)
    {
        // Ambil data auction item berdasarkan ID
        $auctionItem = AuctionItem::findOrFail($itemId);

        // Return view untuk halaman checkout auction
        return view('auction.checkoutauction', compact('auctionItem'));
    }

}

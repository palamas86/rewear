<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('items.product')->first();
        return view('wishlist.index', compact('wishlist'));
    }

    public function store(Request $request)
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        return redirect()->route('wishlist.index');
    }
}

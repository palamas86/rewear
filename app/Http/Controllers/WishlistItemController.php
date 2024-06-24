<?php

namespace App\Http\Controllers;

use App\Product;
use App\Wishlist;
use App\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistItemController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'product_id' => $product->id,
        ]);

        return redirect()->route('wishlist.index');
    }

    public function destroy(WishlistItem $wishlistItem)
    {
        $wishlistItem->delete();
        return redirect()->route('wishlist.index');
    }
}

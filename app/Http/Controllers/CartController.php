<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Product;
use App\Shop;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    public function add(Product $product)
    {
        // add the product to cart
        \Cart::session(auth()->id())->add(
            array(
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array(
                    'cover_img' => $product->cover_img,
                    'shop_id' => $product->shop_id,
                ),
                'associatedModel' => $product
            )
        );



        return redirect()->route('cart.index');

    }

    public function index()
    {

        $cartItems = \Cart::session(auth()->id())->getContent();



        return view('cart.index', compact('cartItems'));
    }

    public function destroy($itemId)
    {

        \Cart::session(auth()->id())->remove($itemId);

        return back();
    }

    public function update($rowId)
    {

        \Cart::session(auth()->id())->update($rowId, [
            'quantity' => [
                'relative' => false,
                'value' => request('quantity')
            ]
        ]);

        return back();
    }

    public function checkout()
    {
        // Ambil cart items untuk ditampilkan di halaman checkout
        $cartItems = \Cart::session(auth()->id())->getContent();

        // Kelompokkan item berdasarkan shop_id
        $groupedItems = $cartItems->groupBy(function ($item) {
            return $item->associatedModel->shop_id;
        });

        return view('cart.checkout', compact('groupedItems'));
    }

    public function applyCoupon()
    {
        $couponCode = request('coupon_code');

        $couponData = Coupon::where('code', $couponCode)->first();

        if (!$couponData) {
            return back()->withMessage('Sorry! Coupon does not exist');
        }


        //coupon logic
        $condition = new \Darryldecode\Cart\CartCondition(
            array(
                'name' => $couponData->name,
                'type' => $couponData->type,
                'target' => 'total',
                'value' => $couponData->value,
            )
        );

        Cart::session(auth()->id())->condition($condition); // for a speicifc user's cart


        return back()->withMessage('coupon applied');

    }
}
